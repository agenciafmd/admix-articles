@extends('agenciafmd/admix::partials.crud.form')

@section('form')
    @formModel(['model' => optional($model), 'create' => route('admix.articles.store'), 'update' => route('admix.articles.update', [($model->id) ?? 0]), 'id' => 'formCrud', 'class' => 'mb-0 card-list-group card' . ((count($errors) > 0) ? ' was-validated' : '')])
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
            @formText(['Código', 'id', null, ['disabled' => true]])
        @endif

        @formIsActive(['Ativo', 'is_active', null, ['required']])

        @formBoolean(['Destaque', 'star', null, ['required']])

        @if(config('admix-articles.category'))
            @include('agenciafmd/categories::partials.form.select', [
                'label' => config('admix-categories.articles-categories.name'),
                'name' => 'category_id',
                'type' => 'articles-categories',
                'required' => true
            ])
        @endif

        @formText(['Nome', 'name', null, ['required']])

        @if(config('admix-articles.call'))
            @formText(['Chamada', 'call', null])
        @endif

        @if(config('admix-articles.short_description'))
            @if(config('admix-articles.wysiwyg'))
                @formTextarea(['Resumo', 'short_description', null])
            @else
                @formTextareaPlain(['Resumo', 'short_description', null])
            @endif
        @endif

        @if(config('admix-articles.wysiwyg'))
            @formTextarea(['Descrição', 'description', null])
        @else
            @formTextareaPlain(['Descrição', 'description', null])
        @endif

        @if(config('admix-articles.video'))
            @formText(['Vídeo', 'video', null, [], 'Ex: https://youtu.be/6vk04LqLiCc'])
        @endif

        @if(config('admix-articles.published_at'))
            @formDatetime(['Data de Publicação', 'published_at', null, ['required']])
        @endif

        @if(config('admix-articles.downloads'))
            @formMedias(['Downloads', 'downloads', $model])
        @endif

        @foreach(config('upload-configs.article') as $key => $image)
            @if($image['multiple'])
                @formImages([$image['name'], $key, $model])
            @else
                @formImage([$image['name'], $key, $model])
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
    @formClose()
@endsection
