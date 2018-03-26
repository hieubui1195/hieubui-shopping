<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Lang;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            // Ignores notices and reports all other kinds... and warnings
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
        }
        $formType = $this->input('formType');


        switch ($formType) {
            case config('custom.form_type.create'):
                $rules = [
                    'name' => 'required|unique:products',
                    'description' => 'required',
                    'price' => 'required|numeric|min:1',
                    'amount' => 'required|numeric|min:1',
                ];

                $images = count($this->input('images'));
                foreach(range(0, $images) as $index) {
                    $rules['images.' . $index] = 'required|image|mimes:jpg,jpeg,bmp,png|max:2000';
                }

                return $rules;

            case config('custom.form_type.edit'):
                $rules = [
                    'name' => 'required',
                    'description' => 'required',
                    'price' => 'required|numeric|min:1',
                    'amount' => 'required|numeric|min:1',
                ];

                $images = count($this->input('images'));
                foreach(range(0, $images) as $index) {
                    $rules['images.' . $index] = 'image|mimes:jpg,jpeg,bmp,png|max:2000';
                }

                return $rules;
        }
    }

    public function messages()
    {
        return [
            'name.required' => Lang::get('validation.required', ['attribute' => 'product']),
            'name.unique' => Lang::get('validation.unique', ['attribute' => 'product']),
            'description.required' => Lang::get('validation.required'),
            'price.required' => Lang::get('validation.required'),
            'price.numeric' => Lang::get('validation.numeric'),
            'price.min' => Lang::get('validation.min.numeric', ['min' => 1]),
            'amount.required' => Lang::get('validation.required'),
            'amount.numeric' => Lang::get('validation.numeric'),
            'amount.min' => Lang::get('validation.min.numeric', ['min' => 1]),
            'images.*.required' => Lang::get('validation.required'),
            'images.*.image' => Lang::get('validation.image'),
            'images.*.mimes' => Lang::get('validation.mimes', ['value' => 'jpg,jpeg,bmp,png']),
            'images.*.max' => Lang::get('validation.max.file', ['max' => 2000]),
        ];
    }
}
