<?php

namespace App\Http\Controllers;

use App\Loan;
use Illuminate\Http\Request;
use Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $loans = Loan::all();
        foreach ($loans as $loan) {
            $loan->user = $loan->user;
        }
        return $loans;
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
        $data = $request->only(['period', 'interest', 'amount']);
        $trans = new Loan($data);
        $trans->user_id = Auth::user()->id;
        $trans->state = 0;
        $trans->score = 50;
        $trans->save();
        $trans->user = $trans->user;
        return $trans;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show($loan)
    {
        //
        $loan = Loan::find($loan);
        $loan->user = $loan->user;
        return $loan;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $loan)
    {
        //
        $loan = Loan::find($loan);
        if ($request->input('state') == 1 && $loan->state != 1){
            $loan->user->balance = $loan->user->balance + $loan->amount;
            $loan->user->save();
        }
        $loan->update($request->all());
        $loan->save();
        $loan->user = $loan->user;
        return $loan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($loan)
    {
        //
        $loan = Loan::find($loan);
        $loan->delete();
        return response()->json(['success' => 'Deleted successfully']);
    }
}
