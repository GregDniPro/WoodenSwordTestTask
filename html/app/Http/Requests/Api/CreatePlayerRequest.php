<?php declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class CreatePlayerRequest
 *
 * @package App\Http\Requests\Api
 *
 * @property string $display_name
 * @property int|null $auto
 */
class CreatePlayerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'display_name' => ['required', 'string', 'max:255', 'unique:players'],
            'auto' => ['int', 'min:0', 'max:1'],
        ];
    }

    /**
     * Return json errors
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'status' => JsonResponse::HTTP_NOT_ACCEPTABLE,
                'errors' => (new ValidationException($validator))->errors(),
            ], JsonResponse::HTTP_NOT_ACCEPTABLE)
        );
    }
}
