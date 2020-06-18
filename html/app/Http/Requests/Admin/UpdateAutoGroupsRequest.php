<?php declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Rules\WeightSumRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAutoGroupsRequest
 *
 * @package App\Http\Requests\Api
 * @property array $autogroups_data
 */
class UpdateAutoGroupsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'autogroups_data' => ['required', 'array', new WeightSumRule],
        ];
    }
}
