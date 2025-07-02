<?php

namespace App\Http\Requests\Brandbook;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandbookCustomFieldRequest extends FormRequest
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
            'introduction_title' => 'nullable|string',
            'introduction_text' => 'nullable|string',
            'vision_title' => 'nullable|string',
            'vision_text' => 'nullable|string',
            'mission_title' => 'nullable|string',
            'mission_text' => 'nullable|string',
            'core_title' => 'nullable|string',
            'core_text' => 'nullable|string',
            'logo_title' => 'nullable|string',
            'logo_text' => 'nullable|string',
            'versions_title' => 'nullable|string',
            'versions_text' => 'nullable|string',
            'icon_title' => 'nullable|string',
            'icon_text' => 'nullable|string',
            'proportions_title' => 'nullable|string',
            'proportions_text' => 'nullable|string',
            'space_title' => 'nullable|string',
            'space_text' => 'nullable|string',
            'size_title' => 'nullable|string',
            'size_text' => 'nullable|string',
            'misuse_title' => 'nullable|string',
            'misuse_text' => 'nullable|string',
            'pallette_title' => 'nullable|string',
            'pallette_text' => 'nullable|string',
            'tab_contents' => 'nullable|array',
            'tab_contents.*.id' => 'nullable|exists:tab_contents,id',
            'tab_contents.*.title' => 'nullable|string',
            'tab_contents.*.description' => 'nullable|string',
            'tab_contents.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'tab_contents.*.width' => 'nullable|numeric',
            'tab_contents.*.height' => 'nullable|numeric'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->tab_contents && count($this->tab_contents) > 0) {
                foreach ($this->tab_contents as $index => $tabContent) {
                    if (empty($tabContent['title']) && empty($tabContent['description']) && empty($tabContent['image'])) {
                        $validator->errors()->add('tab_contents.'.$index.'.empty', 'At least one field must be provided.');
                    }
                }
            }
        });
    }
}
