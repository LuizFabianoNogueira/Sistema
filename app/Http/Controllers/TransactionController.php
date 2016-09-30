<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function transactionOpen($account_id)
    {
        $ObjTransaction = new Transaction();
        $ObjTransaction->account_id = $account_id;
        $ObjTransaction->transaction_type = 1; #entrada
        $ObjTransaction->description = 'Abertura de conta';
        $ObjTransaction->value = "0.00";
        $ObjTransaction->previous_balance = "0.00";
        $ObjTransaction->current_balance = "0.00";
        $ObjTransaction->save();
    }

    public function transaction()
    {

        $ObjTransaction = new Transaction();
    }
}
