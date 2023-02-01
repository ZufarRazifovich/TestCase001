<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CreateUrlRequest extends FormRequest
{
    public function rules()
    {
        return [
            'url' => 'required|url|max:255',
            'check_periodicity' => 'required|integer',
            'repeat_periodicity' => 'required|integer',
        ];
    }
}