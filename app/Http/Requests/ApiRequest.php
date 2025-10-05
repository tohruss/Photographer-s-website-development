<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //body
        ];
    }
    protected function throwValidationError(string $message, string $errorCode, array $errors = [])
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => $message,
                'error_code' => $errorCode,
                'errors' => $errors,
                'timestamp' => now()->toISOString(),
                'path' => $this->path(),
            ], 422)
        );
    }

}
