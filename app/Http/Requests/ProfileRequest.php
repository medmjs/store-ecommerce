<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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

            'userName'=>'required',
            'email'=>'required|email|unique:admins,email,'.$this->id,
            //'email'=>'required|email',
            'password'=>'nullable|min:6',
            'password_confirmation' => 'nullable|required_with:password|same:password|min:6'



        ];
    }
    public function messages()
    {
        return [

            'userName.required'=>'يجب كتابة الأسم',
            'email.required'=>'يجب كتابة الأيمل',
            'email.email'=>'صيغةالأيمل غير صحيحه',




        ];
    }

}
