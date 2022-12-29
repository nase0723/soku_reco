<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreMatterRequest extends FormRequest
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
            'name' => ['required'],
            'place' => ['required'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $res = response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 400);
        throw new HttpResponseException($res);
    }

    public function messages() {
        return [
            'name.required' => '「名前」は必須です',
            'place.required' => '「場所」は必須です',
        ];
    }
}
