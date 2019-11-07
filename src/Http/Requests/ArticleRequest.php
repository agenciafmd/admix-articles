<?php

namespace Agenciafmd\Articles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules()
    {
        $data = [
            'is_active' => 'required|boolean',
            'name' => 'required|max:150',
            'description' => 'required',
            'short_description' => 'nullable',
            'video' => 'nullable',
        ];

        if (config('admix-articles.category')) {
            $data['category_id'] = 'required|integer';
        }

        if (config('admix-articles.call')) {
            $data['call'] = 'nullable|max:250';
        }

        if (config('admix-articles.published_at')) {
            $data['published_at'] = 'required';
        }

        return $data;
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
