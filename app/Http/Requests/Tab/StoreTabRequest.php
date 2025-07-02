<?php

namespace App\Http\Requests\Tab;

use App\Rules\Base64Image;
use Illuminate\Foundation\Http\FormRequest;

class StoreTabRequest extends FormRequest
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
            'book_id' => 'required|exists:brandbooks,id',
            'title' => 'required|string',
            'icon' => ['required',new Base64Image],
            'order' => 'required|numeric'
        ];
    }
}
