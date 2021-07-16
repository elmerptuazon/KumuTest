<?php

namespace App\Http\Requests\Github;

use Illuminate\Foundation\Http\FormRequest;

class ListOfUsersRequest extends FormRequest
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
            'usernames'=>'required|array|between:1,10',
        ];
    }
}
