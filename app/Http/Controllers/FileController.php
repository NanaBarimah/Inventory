<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'name'     => 'required',
            'name.*'   => 'mimes:doc, pdf, docx, zip'
        ]);

        if($request->hasFile('name')) {
            foreach($request->file('name') as $file){
                $fileName = $file->getClientOriginalName();
                $fileName = time(). '-' . $fileName->hashName();
                $file->move('files', $fileName);
                $data[] = $fileName;
            }
        }

        $file = new File();

        $file->asset_id = $request->asset_id;
        $file->name     = json_encode($data);

        if($file->save()) {
            return response()->json([
                'error'   => false,
                'data'    => $file,
                'message' => 'File uploaded successfully!'
            ]);
        } else {
            return response()->json([
                'error'   => true,
                'message' => 'Could not upload file. Try Again!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $delete = $file->delete();

        if($delete) {
            return response()->json([
                'error'   => false,
                'message' => 'File deleted successfully!'
            ]);
        } else {
            return response()->json([
                'error'   => true,
                'message' => 'Error deleting file. Try Again!'
            ]);
        }
    }
}
