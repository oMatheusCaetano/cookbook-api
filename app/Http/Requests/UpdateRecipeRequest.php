<?php

namespace App\Http\Requests;

class UpdateRecipeRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'                      => 'string|min:2|max:255',
            'description'               => 'string',
            'prep_time'                 => 'string|min:2|max:255',
            'servings'                  => 'string|min:2|max:255',

            'ingredients'               => 'array|min:1',
            'ingredients.*.description' => 'string|max:255',

            'steps'                     => 'array|min:1',
            'steps.*.description'       => 'string',
        ];
    }
}
