<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegisterRequest extends FormRequest
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
            'email' => 'required',
            'name' => 'required',
            'password' => 'required | min:2 | max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => "email is required",
            'password.required' => "password is required",
            'name.required' => "name is required",
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
                'message' => $message[0]
            ];
        }
        return $transformed;
//        return response()->json([
//            'errors' => $transformed
//        ], \Illuminate\Http\JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function failedValidation(Validator $validator)
    {
        //dd($validator->errors()->toArray());
        $data['data']['errors'] = $this->response($validator->errors()->toArray());
        $data['status_code'] = 422;
        throw new HttpResponseException(response()->json($data, 422));
    }


}
