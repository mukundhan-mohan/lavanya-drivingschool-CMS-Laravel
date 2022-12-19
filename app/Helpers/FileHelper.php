<?php

namespace App\Helpers;

use Closure;
use Intervention\Image\Facades\Image as Image;
use Intervention\Image\Constraint;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use File;
use Illuminate\Http\File as FileHttp;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Save the uploaded image.
     *
     * @param UploadedFile $file     Uploaded file.
     * @param int          $maxWidth
     * @param string       $path
     * @param Closure      $callback Custom file naming method.
     *
     * @return string File name.
     */
    public static function saveImage(UploadedFile $file, $dimention, $path = null)
    {
        $thumbPath = $path . "thumbnail/";
        $originalPath = $path;
        $originalFile = $file;
        
        $destinationPath = public_path($thumbPath);
        if(!File::isDirectory($destinationPath))  {
                    File::makeDirectory($destinationPath, 0777, true, true);
         }
        $resized = 0;
        $fileName = self::getFileName($file);
        try {
            $img = self::makeImage($file);
            if(@config("geosentinel.{$dimention}.width")) {
               $width =  @config("geosentinel.{$dimention}.width");
            }  else {
               $sizes = getimagesize($file);
               $width = $sizes[0]; 
            }
            $img = self::resizeImage($img,  $width, null);
            self::uploadImage($img, $fileName, $thumbPath);
            $resized = 1;
        } 
        catch (\Intervention\Image\Exception\NotReadableException $e) {
            self::saveWithoutResize($file, $path);
        }

        $originalPath = public_path($originalPath);
        $destinationPath = $originalPath;

        if(!File::isDirectory($destinationPath))  {
                    File::makeDirectory($destinationPath, 0777, true, true);
         }
         if($resized == 1) {
            $originalFile->move($destinationPath, $fileName);
         } else {
            File::copy( public_path($thumbPath.$fileName) , $destinationPath.$fileName );
         }

         return $fileName;
    }

    public static function saveWithoutResize(UploadedFile $file, $path = null) {
        $oFile = $file;
        $fileName = self::getFileName($file);
        $extension = self::getExtension($file);
        $thumbPathO = "/". $path . "thumbnail/";
        $file->move(public_path($thumbPathO), $fileName);
        return $fileName;
    }


    /**
     * Save the uploaded image.
     *
     * @param UploadedFile $file     Uploaded file.
     * @param int          $maxWidth
     * @param string       $path
     * @param Closure      $callback Custom file naming method.
     *
     * @return string File name.
     */
    public static function saveS3Image(UploadedFile $file, $dimention, $path = null)
    {
        $oFile = $file;
        $fileName = self::getFileName($file);
    
        $thumbPath = "/". $path . "/thumbnail/".$fileName;
        $thumbPathO = "/". $path . "/thumbnail/";
        $originalPath = "/".$path."/".$fileName;
        $extension = self::getExtension($file);
        if(strtolower($extension) == 'svg') {
            
        }
        if(@config("geosentinel.{$dimention}.width")) {
           $width =  @config("geosentinel.{$dimention}.width");
        }  else {
           $sizes = getimagesize($file);
           $width = $sizes[0]; 
        }

        try {
            $destinationPath = public_path($thumbPathO);
            if(!File::isDirectory($destinationPath))  {
                        File::makeDirectory($destinationPath, 0777, true, true);
             }
            $fileName = self::getFileName($file);
            $img = self::makeImage($file);
            $img = self::resizeImage($img,  $width, null);
            self::uploadImage($img, $fileName, $thumbPathO);
            Storage::disk('s3')->putFileAs($thumbPathO, new FileHttp(public_path($thumbPathO.$fileName)), $fileName);
            File::delete(public_path($thumbPathO.$fileName));
        } 
        catch (\Intervention\Image\Exception\NotReadableException $e) {
            return self::saveWithoutResize($file, $path);
        }
        catch (Exception $e) {
            
            $thumbnail = Image::make($file)->resize($width, null)->encode($extension);
            Storage::disk('s3')->put($thumbPath, (string)$thumbnail, 'public');
        }
        

        /*//$thumbnail = Image::make($file)->resize($width, null)->encode($extension);
      
        Storage::disk('s3')->put($thumbPath, (string)$thumbnail, 'public');*/

        $original = Image::make($oFile)->encode($extension);
        Storage::disk('s3')->put($originalPath , (string)$original, 'public');

         return $fileName;
    }

    /**
     * Get uploaded file's name.
     *
     * @param UploadedFile $file
     *
     * @return null|string
     */
    protected static function getFileName(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();
        $filename = date('Ymd_His') . '_' . strtolower(pathinfo($filename, PATHINFO_FILENAME)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);

        return $filename;
    }

    /**
     * Create the image from upload file.
     *
     * @param UploadedFile $file
     *
     * @return \Intervention\Image\Image
     */
    protected static function getExtension(UploadedFile $file)
    {
        return $file->getClientOriginalExtension();
    }

    /**
     * Create the image from upload file.
     *
     * @param UploadedFile $file
     *
     * @return \Intervention\Image\Image
     */
    protected static function makeImage(UploadedFile $file)
    {
        return Image::make($file);
    }

    /**
     * Resize image to the configured size.
     *
     * @param \Intervention\Image\Image $img
     * @param int                       $maxWidth
     *
     * @return \Intervention\Image\Image
     */
    protected static function resizeImage(\Intervention\Image\Image $img, $maxWidth = 150, $maxHeight = 100)
    {
        $img->resize($maxWidth, null, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $img;
    }

    /**
     * Save the uploaded image to the file system.
     *
     * @param \Intervention\Image\Image $img
     * @param string                    $fileName
     * @param string                    $path
     */
    protected static function uploadImage($img, $fileName, $path)
    {
        $img->save(public_path($path . $fileName), 90);
    }
}