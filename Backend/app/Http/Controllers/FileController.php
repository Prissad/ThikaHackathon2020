<?php

namespace App\Http\Controllers;

use App\FilePDF;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    /*
     * store a file
     */
    public function saveFile(Request $request)
    {
        $file_name_request = $request->file_name;
        if ($file_name_request == '') {
            return response()->json([
                'error' => 'le champ nom de fichier  est obligatoire !'
            ], 403);
        }
        $file_request = $request->file('file');
        $extension =  $request->file->extension();
        $file_full = $request->file_name . "." . $extension;
        if ( $exists = Storage::disk('local')->exists('PDF/' . $file_full))
        {
            return response()->json([
                'error' => 'nom de fichier déjà existant'
            ], 403);
        }
        DB::beginTransaction();
        try {
            $pdf = new FilePDF( [
                'title' => $file_name_request,
                'pdf' => $file_full,

            ]);
            $pdf->save();
            DB::commit();
            $path = $file_request->storeAs(
                'PDF', $file_full
            );
        }catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        $path = $file_request->storeAs(
            'PDF', $file_full
        );
        return response()->json([
            'message' => 'File uploaded successfully!'
        ], 201);
    }


    /***
     * get the file
     */
    public function getFile($id)
    {
        $pdf = FilePDF::where('id', $id)->first();

        return response()->file(  storage_path('app/PDF/') . $pdf->title . '.pdf');
    }

}
