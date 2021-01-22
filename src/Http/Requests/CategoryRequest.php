<?php

namespace Agenciafmd\Articles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    protected $errorBag = 'admix';

    public function rules()
    {
        return [
            'is_active' => [
                'required',
                'boolean',
            ],
            'name' => [
                'required',
                'max:150',
            ],
            'description' => [
                'nullable',
            ],
            'sort' => [
                'nullable',
            ],
            'media' => [
                'array',
                'nullable',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'is_active' => 'ativo',
            'name' => 'nome',
            'description' => 'descrição',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
