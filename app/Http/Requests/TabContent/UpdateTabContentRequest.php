<?php

namespace App\Http\Requests\TabContent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTabContentRequest extends FormRequest
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
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->title) && empty($this->description) && empty($this->image)) {
                $validator->errors()->add('empty', 'At least one field must be provided.');
            }
        });
    }
}
