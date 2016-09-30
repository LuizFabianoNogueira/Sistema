<?php

namespace App\Http\Controllers;

use App\Models\Honest;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class HonestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Cria registro de proteção das contas
     */
    public function createHashs()
    {
        $ObjAccounts = Account::where('user_id', Auth::id())->get();
        foreach ($ObjAccounts as $ObjAccount)
        {
            $ObjHonest = Honest::where('account_id', $ObjAccount->id)->first();
            if(!$ObjHonest)
            {
                $balance = $ObjAccount->balance;
                $ObjNewHonest = new Honest();
                $ObjNewHonest->account_id = $ObjAccount->id;
                $ObjNewHonest->hash = $this->hash($balance);
                $ObjNewHonest->save();
            }
        }
    }

    /**
     * fazupdate do registro de proteção de conta corrente
     * @param $account_id id de refrencia da conta
     * @param $balance saldo da conta
     * @return bool true ou false
     */
    public function updateHashAccount($account_id, $balance)
    {
        $ObjNewHonest = Honest::where('account_id', $account_id)->first();
        if($ObjNewHonest)
        {
            $ObjNewHonest->hash = $this->hash($balance);
            $ObjNewHonest->save();
        }
        else
        {
            return false;
        }
    }

    /**
     * cria código interno de proteção de saldo da conta
     * @param $string saldo da conta
     * @return string hash
     */
    protected function hash($string)
    {
        $string = $string.Auth::id();
        $custo = '08';
        $salt = 'Jf1f11ePArKlBJomM0F6DL';
        return crypt($string, '$2a$' . $custo . '$' . $salt . '$');
    }

    public function checkHashAccount($account_id, $balance)
    {
        $retorno = false;
        $ObjNewHonest = Honest::where('account_id', $account_id)->first();
        if ($ObjNewHonest) {
            $h1 = $ObjNewHonest->hash;
            $h2 = $this->hash($balance);
            if ($h1 === $h2) {
                $retorno = true;
            }
        }

        if (!$retorno)
        {
            $bloqueio =     Account::find($account_id);
            $bloqueio->active = 0;
            $bloqueio->save();
            $this->alert();
        }

        return $retorno;
    }

    public function checkHash()
    {
        $Accounts = Account::where('user_id', Auth::id())->get();
        foreach ($Accounts as $Account) {
            $retorno = false;
            $ObjNewHonest = Honest::where('account_id', $Account->id)->first();
            if ($ObjNewHonest) {
                $h1 = $ObjNewHonest->hash;
                $h2 = $this->hash($Account->balance);
                if ($h1 === $h2) {
                    $retorno = true;
                }
            }

            if (!$retorno) {
                $bloqueio = Account::find($Account->id);
                $bloqueio->active = 0;
                $bloqueio->save();
                $this->alert();
            }
        }

        return $retorno;
    }

    protected function alert()
    {

    }
}
