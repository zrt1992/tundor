<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class TaskRequest extends FormRequest
{
    protected $forceJsonResponse = true;

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
            'name' => 'required | min:2 | max:255',
            'age' => 'required | min:2 | max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "name is required",
            'age.required' => "age is requireds"
        ];
    }

    /**
     * Get the failed validation response for the request.
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {
        $transformed = [];
        foreach ($errors as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0]
            ];
        }
        return response()->json([
            'errors' => $transformed
        ], \Illuminate\Http\JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function failedValidation(Validator $validator)
    {
        $data['data']=$validator->errors();
        throw new HttpResponseException(response()->json($data, 422));
    }


}
