<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkurl extends Model
{
    use HasFactory;
    protected $table='checkurl';
    protected $fillable = [
        'id',
        'url',
        'check_periodicity',
        'repeat_periodicity',
    ];
    public function url()
    {
        return $this->belongsTo('App\Url');
    }
}
