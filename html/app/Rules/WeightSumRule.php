<?php declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class WeightSumRule
 * @package App\Rules
 */
class WeightSumRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $weightSum = array_sum(array_column($value, 'weight'));
        return $weightSum === 100 || $weightSum === 10;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The sum of weight should be 100 or 10, for now? ;)';
    }
}
