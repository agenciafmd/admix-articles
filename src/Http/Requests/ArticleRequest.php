<?php

namespace Agenciafmd\Articles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    protected $errorBag = 'admix';

    public function rules()
    {
        $rules = [
            'is_active' => [
                'required',
                'boolean',
            ],
            'star' => [
                'required',
                'boolean',
            ],
            'name' => [
                'required',
                'max:150',
            ],
            'description' => [
                'required',
            ],
            'short_description' => [
                'nullable',
            ],
            'video' => [
                'nullable',
            ],
            'media' => [
                'array',
                'nullable',
            ],
        ];

        if (config('admix-articles.category')) {
            $rules['category_id'] = [
                'required',
                'integer',
            ];
        }

        if (config('admix-articles.call')) {
            $rules['call'] = [
                'nullable',
                'max:250',
            ];
        }

        if (config('admix-articles.published_at')) {
            $rules['published_at'] = [
                'required',
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'is_active' => 'ativo',
            'category_id' => 'categoria',
            'star' => 'destaque',
            'name' => 'nome',
            'call' => 'chamada',
            'short_description' => 'resumo',
            'description' => 'descrição',
            'published_at' => 'data de publicação',
            'video' => 'vídeo',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
