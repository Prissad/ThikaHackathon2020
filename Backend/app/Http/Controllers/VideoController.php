<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Client;
use App\Repositories\VideoRepository;
use App\User;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;


class VideoController extends CrudController
{

    /**
     * VideoController constructor.
     * @param VideoRepository $videoRepository
     */

    public function __construct(VideoRepository $videoRepository)
    {
        $relations = ['ratings.user','comments.comments','filePdfs'];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($videoRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }

    /**
     * Store a video
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function store (Request $request)
    {

        $user_id = Auth::user()->id;
        if ($request->title == '') {
            return response()->json([
                'error' => 'le champ title  est obligatoire !'
            ], 403);
        }
        if ($request->video == '') {
            return response()->json([
                'error' => 'le champ video  est obligatoire !'
            ], 403);
        }
        if ($request->type == '') {
            return response()->json([
                'error' => 'le champ type  est obligatoire !'
            ], 403);
        }
        if ($request->classe_id == '') {
            return response()->json([
                'error' => 'le champ classe_id  est obligatoire !'
            ], 403);
        }
        if ($request->subject_level1_id == '') {
            return response()->json([
                'error' => 'le champ subject_level1_id  est obligatoire !'
            ], 403);
        }


        $file_name_request = $request->title;
        $file_request = $request->file('video');
        $extension = $request->video->extension();
        $new_name = rand();
        $title = $file_name_request . '%%' . $new_name;
        $file_full = $title . '.' .$extension;
        $path = 'Video_files/' . $file_full;



        if ($exists = Storage::disk('local')->exists($path)) {
            return response()->json([
                'error' => 'nom de fichier déjà existant'
            ], 403);
        }
        try {
            $video = new Video([
                'title' => $file_name_request,
                'url' => "app/" . $path,
                'payed' => $request->payed == null? 1 :$request->payed,
                'type' => $request->type,
                'classe_id' => $request->classe_id,
                'user_id' => $user_id,
                'description' => $request->description
            ]);
            $video->save();
            $video->subjectLevel1s()->attach($request->subject_level1_id);
            DB::commit();

            $file_request->storeAs(
                'Video_files', $file_full
            );
            return response()->json([
                'message' => 'Successfully video created to a subjetLevel1!'
            ], 201);
        } catch (\Exception $e)
        {
            //failed logic here
            DB::rollback();
            Storage::disk('local')->delete($path);
            throw $e;
        }
    }

    /**
     * Play video without secret
     * @param $secret
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function playVideoWihtoutAnything ($video_id)

    {
        $video = Video::where('id', $video_id)->first();

        return response()->file(  storage_path('app/Video_files/') . $video->title . '.mp4');
    }

    /**
     * Play video with secret
     * @param $secret
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function playVideoWithSecret ($secret)
    {
        $secrets = explode("&&", $secret);

        $video_id = $secrets[0];
        $user_id = $secrets[1];
        $user = User::where('id',$user_id)->firstOrFail();
        if ($user->role->name == "admin")
        {
            $video = Video::where('id', $video_id)->first();
            return response()->file(  storage_path($video->url) );
        }
        $tokens = $user->tokens;
        $check = false;
        foreach ($tokens as $token)
        {
            if ( $token->revoked == false )
                $check = true;
                break;
        }
        if ( $check == false ) return response()->json([
            'message' => "unauthorized"
        ],401);

        if ( $user->role->name == "client"  )

        {
            $client = Client::where('id',$user_id)->firstOrFail();
            if ( $client->clientDetails->subscription->name != "Free" )
            {
                $video = Video::where('id', $video_id)->first();
                return response()->file(  storage_path('app/Video_files/') . $video->title . '.mp4');
            }
        }
        return response()->json([
            'message' => "unauthorized"
        ],401);

    }

    public function playExpiringVideo ($secret)
    {
        $secrets = explode("&&", $secret);

        return response()->json([
            'url' => URL::temporarySignedRoute(
                'video.play.secret', now()->addMinutes(150), ['secret' => $secret]
            )
        ],201);
    }

    /**
     * Associate laetst video to a subject level1
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function associateLatest (Request $request)
    {
        $video = Video::where('title','!=',null)->orderBy('created_at', 'desc')->first();
        if ($request->subject_level1_id == '') {
            return response()->json([
                'error' => 'le champ subject_level1_id est obligatoire !'
            ], 403);
        }
        DB::beginTransaction();
        try {
            $video->subjectLevel1s()->attach($request->subject_level1_id);
            $video->save();
            DB::commit();
            return response()->json([
                'message' => "Successfully associated the LATEST video to the subject level 1!"
            ],201);


        }catch (\Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * associate a video to a subjectLevel1
     *
     * @param  [uuid] video_id
     * @param  [uuid] subject_level1_id
     * @return [string] message
     * @throws \Exception
     */
    public function associate (Request $request)
    {
        if ($request->subject_level1_id == '') {
            return response()->json([
                'error' => 'le champ subject_level1_id est obligatoire !'
            ], 403);
        }
        if ($request->video_id == '') {
            return response()->json([
                'error' => 'le champ video_id est obligatoire !'
            ], 403);
        }
        DB::beginTransaction();
        try {
            $video = Video::where('id', $request->video_id )->first();
            $video->subjectLevel1s()->attach($request->subject_level1_id);
            $video->save();
            DB::commit();
            return response()->json([
                'message' => "Successfully associated the video to the subject level 1!"
            ],201);


        }catch (\Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

    }
}
