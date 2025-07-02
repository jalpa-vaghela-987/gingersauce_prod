<?php

namespace App\Traits;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageTrait{

    public function saveImage( UploadedFile $image, $path ){

        if ( !file_exists( $path ) ){
            mkdir( $path, 0775, true );
        }

        $original_image_name      = md5( $image->getClientOriginalName() . time() );
        $original_image_extension = $image->getClientOriginalExtension();

        $Image = Image::make( $image );

        $crop_size = $Image->getWidth() > $Image->getHeight() ? $Image->getHeight() : $Image->getWidth();
        $Image->crop($crop_size,$crop_size);

        $Image->save( $path . DIRECTORY_SEPARATOR . $original_image_name . '.' . $original_image_extension );
        $original_image_name .= '.' . $original_image_extension;

        return $original_image_name;
    }

    public function saveCustomCoverImage( UploadedFile $image, $user_id, $brand_book_id ){
        $path = public_path( config('app.images_path') . $user_id . '/' . $brand_book_id . '/' );
        return $this->saveImage( $image, $path );
    }
    /**
     * Upload base64 Image
     * 
     * @param int base64Image
     * 
     * @param string path
     * 
     * @return string path
     */
    public function uploadBase64Image($base64Image, $path)
    {
        if ( !file_exists( $path ) ){
            mkdir( $path, 0775, true );
        }
        $base64String = substr($base64Image, strpos($base64Image, ',') + 1);
        $imageData  =   base64_decode($base64String);
        $f  = finfo_open();
        $mimeType = finfo_buffer($f, $imageData, FILEINFO_MIME_TYPE);
        if($mimeType == "image/svg"){
            $svgContent = $this->modifySVGDimensions($imageData, 18, 18);
            return $svgContent;
        }
        $filename   =   uniqid() . '.png';
        $image      =   Image::make($imageData);
        $filePath   =   $path . $filename;
        Storage::disk('public')->put($filePath, (string) $image->encode());
        return $filePath;
    }
    private function modifySVGDimensions($svgContent, $newWidth, $newHeight)
    {
        $svg = simplexml_load_string($svgContent);
        $svg['width'] = $newWidth;
        $svg['height'] = $newHeight;
        return $svg->asXML();
    }

}
