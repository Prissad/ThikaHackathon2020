<?php

namespace App\Http\Controllers;

use App\Repositories\RatingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingController extends CrudController
{

    /**
     * RatingController constructor.
     * @param RatingRepository $ratingRepository
     */

    public function __construct(RatingRepository $ratingRepository)
    {
        $relations = ['user'];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($ratingRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }

    public function store(Request $request)
    {
        if ($request->rating == '') {
            return response()->json([
                'error' => 'le champ rating  est obligatoire !'
            ], 403);
        }
        if ($request->video_id == '') {
            return response()->json([
                'error' => 'le champ video_id  est obligatoire !'
            ], 403);
        }
        $user_id = Auth::user()->id;

        if (  DB::table('ratings')
            ->where('video_id', '=', $request->video_id)
            ->where('user_id', '=', $user_id)
            ->count() !=0 )
            return response()->json(
                [
                    'message' => 'vous avez déjà voté !'
                ],401);


        $request->merge(['user_id' => $user_id]);
        return parent::store($request);
    }

}
