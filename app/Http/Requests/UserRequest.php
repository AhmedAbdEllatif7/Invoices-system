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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = request()->id;
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' .$id,
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required',
            'status' => 'required',
        ];
    }
}
