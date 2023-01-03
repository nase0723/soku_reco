<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreAppointmentRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        $res = response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 400);
        throw new HttpResponseException($res);
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'matter_id' => ['required'],
        ];
    }

    public function messages() {
        return [
            'matter_id.required' => '「案件名」を選択してください',
        ];
    }
}
