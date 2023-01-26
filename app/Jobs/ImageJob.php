<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        // 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($request)
    {
        if ($request->hasFile('profile_image')) {
           
            foreach($this->request->file('profile_image') as $file){

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
    
        }
    }
}
