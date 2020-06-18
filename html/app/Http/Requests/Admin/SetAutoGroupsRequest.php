<?php declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SetAutoGroupsRequest
 *
 * @package App\Http\Requests\Api
 * @property array $groups_data
 */
class SetAutoGroupsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'groups_data' => ['required', 'array'],
        ];
    }
}
