<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFolder extends FormRequest
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
      $folder_id = isset($this->folder_id)? $this->folder_id : null;

        return [
            'name' => 'required|unique:folders,name,'.$folder_id.'|max:255'
        ];
    }
}
