<?php

namespace App\Http\Controllers;

use App\Client;
use App\Code;
use App\Repositories\CodeRepository;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CodeController extends CrudController
{

    /**
     * CodeController constructor.
     * @param CodeRepository $codeRepository
     */

    public function __construct(CodeRepository $codeRepository)
    {
        $relations = [];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($codeRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
    public function store (Request $request)
    {

        if ($request->code == '') {
            return response()->json([
                'error' => 'le champ code  est obligatoire !'
            ], 403);
        }
        //dd(Code::where(['code' => $request->code]));
        if ( Code::where(['code' => $request->code])->first() )
            return response()->json([
                'error' => 'Code  existe déjà!'
            ], 403);
        $code = new Code([
            'code' => $request->code,
            'point' => 10,
            'verified' => false,
        ]);
        DB::beginTransaction(); //Start transaction!
        try
        {
            $code->save();
            DB::commit();
            return response()->json([
                'success' => 'Code ajouté avec succès'
            ], 201);
        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;

        }
    }
    public function verify(Request $request)
    {
        $code = $request->code;
        if(
            Code::where([
            'code' => $code,
            'verified'=>'0'])
                ->count()==0
        )
            return response()->json(['error'=>'No such code'], 400);

        // update the subscription of the user
        $paid_subscription = Subscription::where(['name' => 'Silver'])->first()->id;
        Client::where(['id' =>Auth::user()->id])->first()->clientDetails()->update([
            'subscription_id' => $paid_subscription
        ]);

        // update the code
        Code::where(['code' => $code])
            ->update([
            'client_id'=>Auth::user()->id,
            'verified'=>'1'
        ]);

        return response()->json(['success'=>'Code valide'], 201);
    }
}
