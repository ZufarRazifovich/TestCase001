<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUrlFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'required|url|max:255',
            'check_periodicity' => 'required|integer',
            'repeat_periodicity' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'url.required' => 'Юрл адрес не может оставаться пустым.',
            'check_periodicity.required'  => 'Поле период проверки, должно быть заполнено'
        ];
    }
}
