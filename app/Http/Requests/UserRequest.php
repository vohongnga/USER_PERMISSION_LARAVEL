<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'display_name'     =>'required',
            'role_id'    =>'not_in:0',
            'email' =>'required|email|unique:users',
            'password'=>'required|min:8',
            'password_confirmation'=>'required|same:password'
        ];
    }

    /**
     * Get the message when error validate
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
