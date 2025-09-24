<?php

namespace App\Http\Requests;

class CreateRecipeRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'                      => 'required|string|min:2|max:255',
            'description'               => 'nullable|string',
            'prep_time'                 => 'nullable|string|min:2|max:255',
            'servings'                  => 'nullable|string|min:2|max:255',

            'ingredients'               => 'required|array|min:1',
            'ingredients.*.description' => 'required|string|max:255',

            'steps'                     => 'required|array|min:1',
            'steps.*.description'       => 'required|string',
        ];
    }
}
