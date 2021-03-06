<?php

namespace App\Http\Requests;

use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
      $user_id = isset($this->user_id) ? Hashids::decode($this->user_id)[0] : null;
        return [
            'name'=>'required|max:255',
            'email' =>'required|email|unique:users,email,'.$user_id.'|max:255',
            'password'=> 'confirmed|max:255',
            'admin'=> 'boolean',
        ];
    }
}
