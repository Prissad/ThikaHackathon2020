<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Client;
use App\FilePDF;
use App\Repositories\SubjectLevel1Repository;
use App\Subject;
use App\SubjectLevel1;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class SubjectLevel1Controller extends CrudController
{

    /**
     * SubjectLevel1Controller constructor.
     * @param SubjectLevel1Repository $subjectLevel1Repository
     */

    public function __construct(SubjectLevel1Repository $subjectLevel1Repository)
    {
        $relations = [
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.video.filePdfss',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.videos.filePdfs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.videos.filePdfs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.subjectLevel1s.videos.filePdfs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.subjectLevel1s.videos.filePdfs',
            'subjectLevel1s.subjectLevel1s.filePDFs',
            'subjectLevel1s.subjectLevel1s.videos.filePdfs',
            'subjectLevel1s.filePDFs',
            'subjectLevel1s.videos.filePdfs',
            'filePDFs',
            'videos.filePdfs'
        ];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($subjectLevel1Repository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }

    /**
     * Create title a subject ( with or without pdf , with and without video)
     *
     * @param  [string] name
     * @return [string] message
     * @throws \Exception
     */
    public function AddSubjectLevel1ToSubject(Request $request, $subject_id)
    {

        $admin_all = Admin::all();
        $admin = $admin_all[0];
        $admin_id = $admin->id;

        if ($request->name == '') {
            return response()->json([
                'error' => 'le champ name  est obligatoire !'
            ], 403);
        }

        //this is the subject that we are going to add the subject level title.
        $subject = Subject::where('id', $subject_id)->first();
        $subject_id = $subject->id;

        DB::beginTransaction(); //Start transaction!
        try {
            $subject_level1 = new SubjectLevel1([
                'name' => $request->name,
                'subject_id' => $subject_id
            ]);

            $subject->subjectLevel1s()->save($subject_level1);

            DB::commit();
            return response()->json([
                'message' => 'Successfully added title to the subject!'
            ], 201);
        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;
        }

    }

    /**
     * Create another title for a title of a subject ( with or without pdf , with and without video)
     * @param  [string] name
     * @return [string] message
     * @throws \Exception
     */
    public function AddSubjectLevel1ToSubjectLevel1(Request $request, $subject_level1_id)
    {
        $admin_all = Admin::all();
        $admin = $admin_all[0];
        $admin_id = $admin->id;

        if ($request->name == '') {
            return response()->json([
                'error' => 'le champ name  est obligatoire !'
            ], 403);
        }
        $subject_level1_parent = SubjectLevel1::where('id', $subject_level1_id)->first();
        $subject_level1_parent_id = $subject_level1_parent->id;

        DB::beginTransaction(); //Start transaction!
        try {

            $subject_level1 = new SubjectLevel1([
                'name' => $request->name,
                'subject_level1_id' => $subject_level1_parent_id

            ]);
            $subject_level1_parent->subjectLevel1s()->save($subject_level1);

            DB::commit();
            return response()->json([
                'message' => 'Successfully added another title to the title!'
            ], 201);
        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
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
            /*else
                {
                    $client_classe= $client->clientDetails->classe;
                    $subject_level1 = SubjectLevel1::where('id',$id)->firstOrFail();
                    $subject_level1_classe = $subject_level1->subject->classe;
                    if ( $client_classe == $subject_level1_classe )
                        return parent::show($id);
                    else
                        return response()->json([
                            'message' => 'unauthorized'
                        ],401);
                }*/

        }
        return parent::show($id);
    }

}




