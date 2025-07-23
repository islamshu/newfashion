<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
       use HasTranslations;

    protected $fillable = ['name','delivery_fee'];

    public $translatable = ['name'];
}
