<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Transaction::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->only(['receiver_id', 'amount']);
        $sender = Auth::user();
        if($sender->balance < $data['amount'])
            return response()->json(['error'=>'No money in account', 400]);
        $trans = new Transaction($data);
        $trans->sender_id = Auth::user()->id;
        $trans->save();
        $receiver = \App\User::find($trans->receiver_id);
        $sender->balance = $sender->balance - $data['amount'];
        $receiver->balance = $receiver->balance + $data['amount'];
        $sender->save(); $receiver->save();
        return $trans;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($transaction)
    {
        //
        $transaction = Transaction::find($transaction);
        return $transaction;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transaction)
    {
        //
        $transaction = Transaction::find($transaction);
        $transaction->update($request->all());
        $transaction->save();
        return $transaction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($transaction)
    {
        //
        $transaction = Transaction::find($transaction);
        $transaction->delete();
        return response()->json(['success' => 'Deleted successfully']);
    }
}
