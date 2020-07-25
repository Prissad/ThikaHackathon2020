<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\CommentRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends CrudController
{

    /**
     * CommentController constructor.
     * @param CommentRepository $commentRepository
     */

    public function __construct(CommentRepository $commentRepository)
    {
        $relations = ['comments'];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($commentRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
    public function store (Request $request)
    {
        $validated = Validator::make($request->all(), [
            'video_id' => 'required',
            'text' => 'required',
            // 'comment_id'=>'nullable|integer',
        ], [
            'required' => 'L\'attribut :attribute est impératif.',
            'unique' => 'Cet :attribute est déja utilisé.',
            'confirmed' => 'Mot de passe et confirmation différents'
        ]);
        if ($validated->fails()) {
            return response()->json($validated->messages(), 401);
        }
        $data = $request->all();
        $comment = new Comment($data);
        //dd(Auth::user());
        $comment->name = Auth::user()->fname . " " . Auth::user()->lname;
        $comment->user_id = Auth::user()->id;

        $comment->save();
        return $comment;
    }
    public function destroy($id)
    {
        $user = Auth::user();
        $user_role = $user->role->name;
        $user_id = $user->id;
        if ( $user_role == "admin" )
            return parent::destroy($id);
        else
        {
            $comment = Comment::where('id',$id)->firstOrFail();
            if ( $comment->user->id == $user_id )
                return parent::destroy($id);
            else
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);

        }
    }
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $user_role = $user->role->name;
        $user_id = $user->id;
        if ( $user_role == "admin" )
            return parent::update($request, $id);
        else
        {
            $comment = Comment::where('id',$id)->firstOrFail();
            if ( $comment->user->id == $user_id )
                return parent::update($request, $id);
            else
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);

        }
    }
}
