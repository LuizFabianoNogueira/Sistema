<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Honest;
use App\Models\Transaction;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function create()
    {
        DB::beginTransaction();

        $AccountDefault = Account::where('user_id', Auth::id())->where('account_type', 1)->first();
        if(!$AccountDefault)
        {
            $ObjAccount = new Account();
            $ObjAccount->account_type = 1;
            $ObjAccount->name = 'Conta Corrente';
            $ObjAccount->user_id = Auth::id();
            $ObjAccount->save();

            $t = new TransactionController();
            $t->transactionOpen($ObjAccount->id);
        }

        $AccountLideranca = Account::where('user_id', Auth::id())->where('account_type', 2)->first();
        if(!$AccountLideranca)
        {
            $ObjAccount = new Account();
            $ObjAccount->account_type = 2;
            $ObjAccount->name = 'Conta Liderança';
            $ObjAccount->user_id = Auth::id();
            $ObjAccount->save();

            $t = new TransactionController();
            $t->transactionOpen($ObjAccount->id);
        }

        $h = new HonestController();
        $h->createHashs();

        DB::commit();

        return Redirect::route('accounts.listGet');
    }

    public function listGet()
    {
        $h = new HonestController();
        $h->checkHash();
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('accounts.account', ['accounts' => $accounts]);
    }

    public function teste()
    {
        DB::beginTransaction();

        $account = Account::where('user_id', Auth::id())->where('account_type', 1)->first();

        $value = rand(0, 9).rand(0, 9).rand(0, 9).".".rand(0, 9).rand(0, 9);
        $current_balance = ($account->balance + $value);

        $Account = new Transaction();
        $Account->account_id = $account->id;
        $Account->transaction_type = 1; #entrada
        $Account->description = 'Teste de movimentação';
        $Account->value = $value;
        $Account->previous_balance = $account->balance;
        $Account->current_balance = $current_balance;
        if($Account->save())
        {
            $ObjAccount = Account::find($account->id);
            $ObjAccount->balance = $current_balance;
            if($ObjAccount->save())
            {
                $h = new HonestController();
                $h->updateHashAccount($account->id, $current_balance);
                DB::commit();
            }
            else
            {
                DB::rollBack();
            }
        }
        else
        {
            DB::rollBack();
        }

        return Redirect::route('accounts.listGet');
    }

    protected function updateBalanceAccount($balance, $account_id)
    {
        DB::beginTransaction();
        $ObjAccount = Account::find($account_id);
        $ObjAccount->balance = $balance;
        $h = new HonestController();
        $h->updateHashAccount($account_id, $balance);
        DB::commit();
    }


}
