<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Client;
use App\Repositories\SubjectRepository;
use App\Subject;
use App\SubjectLevel1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectController extends CrudController
{

    /**
     * SubjectController constructor.
     * @param SubjectRepository $subjectRepository
     */

    public function __construct(SubjectRepository $subjectRepository)
    {
        $relations = [
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.videos',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.videos',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.videos',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.videos',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.videos',
            'subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.videos',
            'subjectLevel1s.filePDFs',
            'subjectLevel1s.videos'

        ];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($subjectRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
    public function store (Request $request)
    {
        if ($request->classe_id == '') {
            return response()->json([
                'error' => 'le champ classe_id  est obligatoire !'
            ], 403);
        }
        if ($request->name == '') {
            return response()->json([
                'error' => 'le champ name  est obligatoire !'
            ], 403);
        }
        $classe = Classe::where('id',$request->classe_id)->first();
        $subjects = $classe->subjects;
        $names = array();
        foreach ($subjects as $subject)
        {
            array_push($names,strtoupper($subject->name ));
        }
        if (in_array(strtoupper($request->name),$names) )
            return response()->json([
                'message' => 'nom de matiere déjà existe pour cette classe'
            ],403);
        DB::beginTransaction();
        $subject = new Subject([
            'name' => $request->name,
            'classe_id' => $request->classe_id
        ]);
        try {
            $subject->save();
            DB::commit();
            return response()->json([
                'message' => 'nom de matiere ajouté avec succès'
            ],201);
        } catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function show($id)
    {
        $role = Auth::user()->role->name;
        if ( $role == "client"){
            $client = Client::where('id',Auth::id())->firstOrFail();
            $subscription = $client->clientDetails->subscription->name;
            if ( $subscription == "Free")
                return response()->json([
                    'message' => 'unauthorized'
                ],401);
            else
            {
                $client_classe= $client->clientDetails->classe;
                $subject = Subject::where('id',$id)->firstOrFail();
                $subject_classe = $subject->classe;
                if ( $client_classe == $subject_classe )
                    return parent::show($id);
                else
                    return response()->json([
                        'message' => 'unauthorized'
                    ],401);
            }

        }
        return parent::show($id);
    }

}
