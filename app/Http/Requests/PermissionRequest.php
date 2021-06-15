<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name'     =>'required|min:8|max:45|unique:permissions,name,'.$this->permission,
            // 'role_id'  =>'required',
            'slug'     =>'unique:permissions,slug'
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
