<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|min:3',
            'color'=>'required',
            'price'=>'required',
            'sale'=>'required',
            'collection'=>'required',
            'gender'=>'required',
            'category'=>'required',
            'image1'=>'required',
            'image2'=>'required',
            'quantity'=>'required'

        ];
    }



    public function messages()
    {
        return [

            'name.min'=>'you should enter at least 3 letters',

            
        ];
    }
}
