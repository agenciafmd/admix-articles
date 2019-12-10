@extends('agenciafmd/admix::partials.crud.form')

@section('form')
    {!! Form::bsOpen(['model' => optional($model), 'create' => route('admix.articles.store'), 'update' => route('admix.articles.update', [$model->id])]) !!}
    <div class="card-header bg-gray-lightest">
        <h3 class="card-title">
            @if(request()->is('*/create'))
                Criar
            @elseif(request()->is('*/edit'))
                Editar
            @else
                Visualizar
            @endif
            {{ config('admix-articles.name') }}
        </h3>
        <div class="card-options">
            @if(strpos(request()->route()->getName(), 'show') === false)
                @include('agenciafmd/admix::partials.btn.save')
            @endif
        </div>
    </div>
    <ul class="list-group list-group-flush">

        @if (optional($model)->id)
            {!! Form::bsText('Código', 'id', null, ['disabled' => true]) !!}
        @endif

        {!! Form::bsIsActive('Ativo', 'is_active', null, ['required']) !!}

        {!! Form::bsBoolean('Destaque', 'star', null, ['required']) !!}

        @if(config('admix-articles.category'))
            @include('agenciafmd/categories::partials.form.select', [
                'label' => config('admix-categories.articles-categories.name'),
                'name' => 'category_id',
                'type' => 'articles-categories',
                'required' => true
            ])
        @endif

        {!! Form::bsText('Nome', 'name', null, ['required']) !!}

        @if(config('admix-articles.call'))
            {!! Form::bsText('Chamada', 'call', null) !!}
        @endif

        @if(config('admix-articles.short_description'))
            @if(config('admix-articles.wysiwyg'))
                {!! Form::bsTextarea('Resumo', 'short_description', null) !!}
            @else
                {!! Form::bsTextareaPlain('Resumo', 'short_description', null) !!}
            @endif
        @endif

        @if(config('admix-articles.wysiwyg'))
            {!! Form::bsTextarea('Descrição', 'description', null) !!}
        @else
            {!! Form::bsTextareaPlain('Descrição', 'description', null) !!}
        @endif

        @if(config('admix-articles.video'))
            {!! Form::bsText('Vídeo', 'video', null, [], 'Ex: https://youtu.be/6vk04LqLiCc') !!}
        @endif

        @if(config('admix-articles.published_at'))
            {!! Form::bsDateTime('Data de Publicação', 'published_at', optional(optional($model)->published_at)->format("Y-m-d\TH:i"), ['required']) !!}
        @endif

        @if(config('admix-articles.downloads'))
            {!! Form::bsMedias('Downloads', 'downloads', $model) !!}
        @endif

        @foreach(config('upload-configs.article') as $key => $image)
            @if($image['multiple'])
                {!! Form::bsImages($image['name'], $key, $model) !!}
            @else
                {!! Form::bsImage($image['name'], $key, $model) !!}
            @endif
        @endforeach
    </ul>
    <div class="card-footer bg-gray-lightest text-right">
        <div class="d-flex">
            @include('agenciafmd/admix::partials.btn.back')

            @if(strpos(request()->route()->getName(), 'show') === false)
                @include('agenciafmd/admix::partials.btn.save')
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection
