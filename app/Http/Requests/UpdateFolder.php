<?php

namespace App\Http\Requests;

use Vinkla\Hashids\Facades\Hashids;
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
      $$folder_id = isset($this->folder_id) ? Hashids::decode($this->folder_id)[0] : null;

        return [
            'name' => 'required|unique:folders,name,'.$folder_id.'|max:255'
        ];
    }
}
