<?php

namespace App\Traits;


use Illuminate\Http\UploadedFile;

trait ImageTrait{

    public function saveImage( UploadedFile $image, $path ){

        if ( !file_exists( $path ) ){
            mkdir( $path, 0775, true );
        }

        $original_image_name      = md5( $image->getClientOriginalName() . time() );
        $original_image_extension = $image->getClientOriginalExtension();

        $Image = \Image::make( $image );

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

}
