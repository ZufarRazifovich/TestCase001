<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Checkurl;

class Url extends Model
{
    use HasFactory;

    protected $table = 'url';

    protected $fillable = [
        'id',
        'url',
        'check_periodicity',
        'repeat_periodicity',
    ];

    public function checkUrls()
    {
        return $this->hasMany('App\Models\Checkurl');
    }
}
