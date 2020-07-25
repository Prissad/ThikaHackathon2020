<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Client;
use App\ClientDetails;
use App\Notifications\SignupActivate;
use App\Repositories\TeacherRepository;
use App\Teacher;
use App\TeacherDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherController extends CrudController
{

    /**
     * TeacherController constructor.
     * @param TeacherRepository $teacherRepository
     */

    public function __construct(TeacherRepository $teacherRepository)
    {
        $relations = ['teaches.classe','teaches.subject'];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($teacherRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
    /**
     * Create a teacher
     *
     * @param  [string] fname
     * @param  [string] lname
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     * @throws \Exception
     */
    public function store(Request $request)
    {
        if ($request->fname == '') {
            return response()->json([
                'error' => 'le champ fname  est obligatoire !'
            ], 403);
        }
        if ($request->lname == '') {
            return response()->json([
                'error' => 'le champ lname  est obligatoire !'
            ], 403);
        }
        if ($request->email == '') {
            return response()->json([
                'error' => 'le champ email  est obligatoire !'
            ], 403);
        }
        $this->validate($request, [
            'password' => 'required|confirmed|min:8',
        ]);


        $teacher = new Teacher([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'activation_token' => Str::random(60),

        ]);
        $teacherDetails = [
        ];

        DB::beginTransaction(); //Start transaction!

        try {
            //saving logic here
            $teacher->save();
            $teacher_details = TeacherDetails::create($teacherDetails);
            $teacher->teacherDetails()->save($teacher_details);
            $teacher->notify(new SignupActivate($teacher));
            DB::commit();
            return response()->json([
                'message' => 'Successfully created teacher! please visit your email to activate your account'
            ], 201);
        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;

        }
    }
    /**
     * Update teacher
     *
     * @param  [string] fname
     * @param  [string] lname
     * @return [string] message
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        // findt the client
        $teacher = Teacher::where('id', $id)->first();
        $validatedData = $request->validate([
            'fname' => 'nullable|string',
            'lname' => 'nullable|string',
        ]);
        $filtred_data = array_filter($validatedData);
        DB::beginTransaction(); //Start transaction!

        try {

        $teacher->update($filtred_data);
        $teacher->save();

        DB::commit();
        return response()->json([
                'message' => 'Successfully updated teacher'
            ], 201);
        } catch (\Exception $e) {
        //failed logic here
        DB::rollback();
        throw $e;

    }




    }
}
