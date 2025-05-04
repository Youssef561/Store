<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // to prevent the user from using these words
        $badWords = ['laravel', 'hack', 'spam'];

        foreach ($badWords as $word) {
            if (stripos($value, $word) !== false) {             // stripos is a case-insensitive it checks if the words is in the value or not
                $fail("The :attribute contains a forbidden word: $word.");
                break;
            }
        }

    }


}
