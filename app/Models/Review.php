<?php

// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Review extends Model
{
    use HasTranslations;

    protected $fillable = ['description', 'stars', 'image', 'name', 'job'];

    public $translatable = ['description','job'];
}
