<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class StorePostRequest extends FormRequest
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
            'name'        => ['required', 'string', 'min:5', 'max:255'],
            'title'       => ['required', 'string', 'min:5', 'max:255'],
            'slug'        => ['required', 'unique:authors,slug', 'max:255'],
            'description' => ['required', 'string', 'min:5', 'max:10000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => ($this->slug) ?? \Str::slug($this->title, '-')
        ]);
    }
}
