<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    protected $fillable = [
        'description',
        'recipe_id',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function ingredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }
}
