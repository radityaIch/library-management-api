<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
    public static function rules($id)
    {
        return [
            'name' => 'required|max:50',
            'email' => [
                'required',
                Rule::unique("members")->ignore($id),
            ],
            'phone' => 'required|numeric',
            'address' => 'required'
        ];
    }
}
