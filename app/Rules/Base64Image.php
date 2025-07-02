<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Image implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $base64String = substr($value, strpos($value, ',') + 1);
        if (base64_decode($base64String, true) === false) {
            return false;
        }
        $decodedData    =   base64_decode($base64String);
        $f  = finfo_open();
        $mimeType = finfo_buffer($f, $decodedData, FILEINFO_MIME_TYPE);
        $validMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/svg',
        ];
        return in_array($mimeType, $validMimeTypes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid icon image.';
    }
}
