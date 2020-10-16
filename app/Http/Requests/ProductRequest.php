<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'=>'required|max:100',
            'slug'=>'required|unique:products,slug,' ,
            'description'=>'required|max:500',
            'short_description'=>'nullable|max:500',
            'categories'=> 'array|min:1',
            'categories.*'=>'numeric|exists:categories,id',
            'tag'=>'array|min:1',
            'tag'=>'required',
            'brand'=>'required|exists:brands,id',

        ];
    }
}