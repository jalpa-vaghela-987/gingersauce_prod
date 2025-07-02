<?php

namespace App\Http\Requests\Brandbook;

use Illuminate\Foundation\Http\FormRequest;

class CustomizeBrandbookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:brandbooks,id',
            'custom' => 'nullable|json',
            'custom_theme_color' => 'nullable|string'
        ];
    }
}
