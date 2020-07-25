<?php

namespace App\Http\Controllers;

use App\Repositories\TeachRepository;
use App\Teach;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachController extends CrudController
{

    /**
     * TeachController constructor.
     * @param TeachRepository $teachRepository
     */

    public function __construct(TeachRepository $teachRepository)
    {
        $relations = [];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($teachRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
    public function store (Request $request)
    {
        if ($request->email == '') {
            return response()->json([
                'error' => 'le champ email  est obligatoire !'
            ], 403);
        }
        if ($request->classe_id == '') {
            return response()->json([
                'error' => 'le champ classe_id  est obligatoire !'
            ], 403);
        }
        if ($request->subject_id == '') {
            return response()->json([
                'error' => 'le champ subject_id  est obligatoire !'
            ], 403);
        }
        $teacher = Teacher::where('email',$request->email)->first();
        if ($teacher  == null) return response()->json([
            'message' => 'Pas de prof avec cet email'
        ],403);

        $teacher_id = Teacher::where('email',$request->email)->first()->id;
        DB::beginTransaction();
        $teach_a = [
            'classe_id' => $request->classe_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $teacher_id
        ];
        if ( Teach::where($teach_a)->first() ) return response()->json([
            'message' => 'cet accès a été déjà donné '
        ]);
        $teach = new Teach($teach_a);
        try {
            $teach->save();
            DB::commit();
            return response()->json([
                'message' => 'l\'accès a été ajouté avec succès !'
            ], 201);

        }catch(\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function removeAccess(Request $request)
    {

        if ($request->email == '') {
            return response()->json([
                'error' => 'le champ email  est obligatoire !'
            ], 403);
        }
        if ($request->classe_id == '') {
            return response()->json([
                'error' => 'le champ classe_id  est obligatoire !'
            ], 403);
        }
        if ($request->subject_id == '') {
            return response()->json([
                'error' => 'le champ subject_id  est obligatoire !'
            ], 403);
        }
        $teacher = Teacher::where('email',$request->email)->first();
        if ($teacher  == null) return response()->json([
            'message' => 'Pas de prof avec cet email'
        ],403);

        $teacher_id = Teacher::where('email',$request->email)->first()->id;
        DB::beginTransaction();
        $teach_a = [
            'classe_id' => $request->classe_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $teacher_id
        ];
        $teach = Teach::where($teach_a)->first();
        if ( ! $teach ) return response()->json([
            'message' => 'cet accès n\'existe pas ! '
        ]);

        try {
            $teach->teacher()->dissociate();
            $teach->subject()->dissociate();
            $teach->classe()->dissociate();
            $teach->delete();
            DB::commit();
            return response()->json([
                'message' => 'l\'accès est retiré avec succès!'
            ], 201);

        }catch(\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
