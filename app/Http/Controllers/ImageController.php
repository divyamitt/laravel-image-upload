<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Jobs\ImageJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;


class ImageController extends Controller
{
    public function index()
    {
        return view('image');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('profile_image')) {

            $data   =   $request->file('profile_image');

            // Chunking file
            $chunks = array_chunk($data, 5);
            foreach ($chunks as $chunk) {
                ImageJob::dispatch($chunk);
            }
    
            foreach($request->file('profile_image') as $file){
    
                //get filename with extension
                $filenamewithextension = $file->getClientOriginalName();
    
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
    
                //get file extension
                $extension = $file->getClientOriginalExtension();
    
                //filename to store
                $filenametostore = $filename.'_'.uniqid().'.'.$extension;
    
                Storage::put('public/images/'. $filenametostore, fopen($file, 'r+'));
                Storage::put('public/images/resize/'. $filenametostore, fopen($file, 'r+'));
    
                //Resize image here
                $thumbnailpath = public_path('storage/images/resize/'.$filenametostore);
                $img = Image::make($thumbnailpath)->resize(800, 800)->save($thumbnailpath);
            }
    
            return redirect('image')->with('success', "Resize Image(s) uploaded successfully on path storage/app/public/images/resize");
        }
    }
}
