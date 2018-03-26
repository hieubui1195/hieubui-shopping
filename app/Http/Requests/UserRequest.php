<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Lang;

class UserRequest extends FormRequest
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
        $formType = $this->input('formType');

        switch ($formType) {
            case config('custom.form_type.create'):
                $rules = [
                    'email' => 'email|required|unique:users',
                    'name' => 'required',
                ];

                return $rules;

            case config('custom.form_type.edit'):
                $rules = [
                    'name' => 'required',
                    'phone' => 'numeric',
                    'password'=>'nullable|string|min:6|confirmed',
                    'avatar' => 'image|mimes:jpg,jpeg,bmp,png|max:2000',
                ];

                return $rules;
        }
        
    }

    public function messages()
    {
        return [
            'email.email' => Lang::get('validation.email'),
            'email.required' => Lang::get('validation.required'),
            'email.unique' => Lang::get('validation.unique'),
            'name.required' => Lang::get('validation.required'),
            'phone.numeric' => Lang::get('validation.numeric'),
            
            'password' => Lang::get('validation.string'),
            'password' => Lang::get('validation.min.string', ['min' => 6]),
            'password' => Lang::get('validation.confirmed'),
            'avatar.image' => Lang::get('validation.image'),
            'avatar.mimes' => Lang::get('validation.mimes', ['value' => 'jpg,jpeg,bmp,png']),
            'avatar.max' => Lang::get('validation.max.file', ['max' => 2000]),
        ];
    }
}
