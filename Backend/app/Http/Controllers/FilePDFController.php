<?php

namespace App\Http\Controllers;

use App\Classe;
use App\FilePDF;
use App\Repositories\FilePDFRepository;
use App\Video;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilePDFController extends CrudController
{

    /**
     * FilePDFController constructor.
     * @param FilePDFRepository $filePDFRepository
     */

    public function __construct(FilePDFRepository $filePDFRepository)
    {
        $relations = [];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($filePDFRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }

    /**
     * Create a PDF to a subjectLevel1
     *
     * @param  [string] title
     * @param  [PDF file] pdf
     * @param  [string] type
     * @param  [uuid] classe_id (optional)
     * @param  [uuid] subject_level1_id (optional)
     * @return [string] message
     * @throws \Exception
     */
    public function store (Request $request)
    {
        if ($request->title == '') {
            return response()->json([
                'error' => 'le champ nom du fichier  est obligatoire !'
            ], 403);
        }
        if ($request->type == '') {
            return response()->json([
                'error' => 'le champ type du fichier  est obligatoire !'
            ], 403);
        }
        if ($request->classe_id == '') {
            return response()->json([
                'error' => 'le champ de l\'id de classe est obligatoire !'
            ], 403);
        }
        if ($request->subject_level1_id == '') {
            return response()->json([
                'error' => 'le champ de l\'id du subject_level1_id est obligatoire !'
            ], 403);
        }
        if ($request->file('pdf') == '') {
            return response()->json([
                'error' => 'aucun pdf n\'est associé'
            ], 403);
        }
        DB::beginTransaction(); //Start transaction!

        $file_name_request = $request->title;
        $new_name = rand();
        $title = $file_name_request . '%%' . $new_name;
        $file_full = $title . '.pdf';
        $path = 'PDF/' . $file_full ;
        try {
            $file_request = $request->file('pdf');

            // begin encrypting
            /*$fileContent = $file_request->get();
            $encryptedContent = encrypt($fileContent);*/
            // check if the file exist
            if ($exists = Storage::disk('local')->exists($path)) {
                return response()->json([
                    'error' => 'nom de fichier déjà existant,veuillez choisir un autre nom '
                ], 403);
            }
            $pdf = new FilePDF([
                'title' => $file_name_request,
                'pdf' =>  "app/" . $path,
                'type' => $request->type,
                'classe_id' => $request->classe_id,
            ]);
            $pdf->save();
            $pdf->subjectLevel1s()->attach($request->subject_level1_id);
            $pdf->save();
            // end encrypting
            DB::commit();
            $path = $file_request->storeAs(
                'PDF', $file_full
            );
            return response()->json([
                'message' => 'Successfully pdf created to a subjetLevel1!'
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
     * Associate a PDF to a subjectLevel1
     *
     * @param  [uuid] file_pdf_id
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
        if ($request->file_pdf_id == '') {
            return response()->json([
                'error' => 'le champ file_pdf_id est obligatoire !'
            ], 403);
        }
        DB::beginTransaction();
        try {
            $pdf = FilePDF::where('id', $request->file_pdf_id )->first();
            $pdf->subjectLevel1s()->attach($request->subject_level1_id);
            $pdf->save();
            DB::commit();
            return response()->json([
                'message' => "Successfully associated the pdf to the subject level 1!"
            ],201);


        }catch (\Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * Associate latest PDF to a subjectLevel1
     *
     * @param  [uuid] file_pdf_id
     * @param  [uuid] subject_level1_id
     * @return [string] message
     * @throws \Exception
     */
    public function associateLatest (Request $request)
    {
        /*$pdf = DB::table('file_p_d_f_s')
            ->orderBy('created_at', 'desc')->first();*/
        $pdf = FilePDF::where('title','!=',null)->orderBy('created_at', 'desc')->first();

        if ($request->subject_level1_id == '') {
            return response()->json([
                'error' => 'le champ subject_level1_id est obligatoire !'
            ], 403);
        }
        DB::beginTransaction();
        try {
            $pdf->subjectLevel1s()->attach($request->subject_level1_id);
            $pdf->save();
            DB::commit();
            return response()->json([
                'message' => "Successfully associated the LATEST pdf to the subject level 1!"
            ],201);


        }catch (\Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * Download the PDF from PDF_Encrypted
     * @param $pdf_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    /*public function downloadPDF ($pdf_id)
    {
        $pdf = FilePDF::where('id', $pdf_id)->first();
        $encryptedContent = Storage::disk('local')->get('PDF_Encrypted/' .  $pdf->title . '.dat');
        $decryptedContent = decrypt($encryptedContent);

        return response()->streamDownload(function() use ($decryptedContent) {
            echo $decryptedContent;
        }, $pdf->title . '.pdf');

    }*/

    /**
     * View the PDF from PDF
     * @param $pdf_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function viewPDF ($pdf_id)
    {
        $pdf = FilePDF::where('id', $pdf_id)->first();
        return response()->file( storage_path($pdf->pdf) );
    }

    /**
     * Associate a PDF (live) to a classe
     *
     * @param  [string] title
     * @param  [PDF file] pdf
     * @param  [uuid] classe_id
     * @return [string] message
     * @throws \Exception
     */
    public function addLiveToClasse(Request $request)
    {
        $classe = Classe::where('id', $request->classe_id)->first();
            if (    $classe->live   )
        {
            $classe->live()->delete();
            $classe->save();
        }

        if ($request->file('pdf') == '')
        {
            return response()->json([
                'error' => 'aucun pdf n\'est associé'
            ], 403);
        }
        DB::beginTransaction(); //Start transaction!

        $file_request = $request->file('pdf');
        $extension =  $request->pdf->extension();
        $new_name = $classe->name . "_live_" . rand();
        //$path = 'PDF_LIVE/' . $new_name . '.dat';
        $file_full = $new_name . '.' . $extension;
        $path = 'PDF_LIVE/' . $file_full;
        try {

            /*$fileContent = $file_request->get();
            $encryptedContent = encrypt($fileContent);*/
            // check if the file exist
            if ($exists = Storage::disk('local')->exists('PDF_LIVE/' . $file_full)) {
                return response()->json([
                    'error' => 'nom de fichier déjà existant,veuillez réessayer une autre fois '
                ], 403);
            }
            $pdf = \App\FilePDF::updateOrCreate([
                'title' => $new_name,
                'pdf' => "app/" . $path,
                'type' => "time table",
            ]);
            $classe->live()->save($pdf);
            DB::commit();
            //Storage::disk('local')->put($path, $encryptedContent);
            $path = $file_request->storeAs(
                'PDF_Live', $file_full
            );

            return response()->json([
                'message' => 'Successfully live PDF created to a classe!'
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
     * Get the file Live from classe
     * @param $classe_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getLiveClasse($classe_id)
    {
        $classe = Classe::where('id', $classe_id)->first();
        $id = $classe->live->id;

        $pdf = FilePDF::where('id', $id)->first();
        /*$encryptedContent = Storage::disk('local')->get('PDF_LIVE/' .  $pdf->title . '.dat');
        $decryptedContent = decrypt($encryptedContent);
        return response()->streamDownload(function() use ($decryptedContent) {
            echo $decryptedContent;
        }, $pdf->title . '.pdf');*/
        return response()->file(  storage_path('app/PDF_Live/') . $pdf->title . '.pdf');

    }

    /**
     * Attach a PDF file to a video
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addFileToVideo (Request $request)
    {
        if ($request->title == '') {
            return response()->json([
                'error' => 'le champ title est obligatoire'
            ], 403);
        }
        if ($request->file('pdf') == '') {
            return response()->json([
                'error' => 'aucun pdf n\'est associé'
            ], 403);
        }
        if ($request->video_id == '') {
            return response()->json([
                'error' => 'le champ video_id est obligatoire'
            ], 403);
        }
        //Start transaction!
        DB::beginTransaction();

        $file_request = $request->file('pdf');
        $file_name_request = $request->title;
        $new_name = rand();
        $title = $file_name_request . '%%' . $new_name;
        $file_full = $title . '.pdf';
        $path = 'PDF/' . $file_full ;

        try {
            /*$fileContent = $file_request->get();
            $encryptedContent = encrypt($fileContent);*/

            // check if the file exist
            if ($exists = Storage::disk('local')->exists($path)) {
                return response()->json([
                    'error' => 'nom de fichier déjà existant,veuillez réessayer une autre fois '
                ], 403);
            }
            $pdf = new FilePDF([
                'title' => $file_name_request,
                'pdf' => "app/" . $path,
                'type' => "video",
            ]);
            $pdf->save();
            $pdf->videos()->attach($request->video_id);
            DB::commit();
            //Storage::disk('local')->put($path, $encryptedContent);
            $path = $file_request->storeAs(
                'PDF', $file_full
            );
            return response()->json([
                'message' => 'Successfully pdf created to a the video!'
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
     * Attach a PDF file to the recently added video
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addFileToLatestVideo (Request $request)
    {
        if ($request->title == '') {
            return response()->json([
                'error' => 'le champ title est obligatoire'
            ], 403);
        }
        if ($request->file('pdf') == '') {
            return response()->json([
                'error' => 'aucun pdf n\'est associé'
            ], 403);
        }
        $video_id = Video::where('title','!=',null)->orderBy('created_at', 'desc')->first()->id;
        DB::beginTransaction(); //Start transaction!

        $file_request = $request->file('pdf');
        $file_name_request = $request->title;
        $new_name = rand();
        $title = $file_name_request . '%%' . $new_name;
        $file_full = $title . '.pdf';
        $path = 'PDF/' . $file_full ;

        try {
            /*$fileContent = $file_request->get();
            $encryptedContent = encrypt($fileContent);*/

            // check if the file exist
            if ($exists = Storage::disk('local')->exists($path)) {
                return response()->json([
                    'error' => 'nom de fichier déjà existant,veuillez réessayer une autre fois '
                ], 403);
            }
            $pdf = new FilePDF([
                'title' => $file_name_request,
                'pdf' => "app/" . $path,
                'type' => "video",
            ]);
            $pdf->save();
            $pdf->videos()->attach($video_id);
            DB::commit();
            //Storage::disk('local')->put($path, $encryptedContent);
            $path = $file_request->storeAs(
                'PDF', $file_full
            );
            return response()->json([
                'message' => 'Successfully pdf created to the latest video!'
            ], 201);
        } catch (\Exception $e)
        {
            //failed logic here
            DB::rollback();
            Storage::disk('local')->delete($path);
            throw $e;
        }
    }

}
