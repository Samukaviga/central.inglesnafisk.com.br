<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{
    protected $table = 'registrations';

    public $incrementing = false; // desativa auto-incremento
    protected $keyType = 'string'; // define chave como string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::random(10); // gera string aleatória de 10 caracteres
            }
        });
    }


    protected $fillable = [
        'name',
        'email',
        'mobile_phone',
        'phone',
        'date_of_birth',
        'age',
        'gender',
        'course',
        'status',
        'lead_source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'fbclid',
        'msclkid',
        'referrer',
        'landing_page',
    ];
}
