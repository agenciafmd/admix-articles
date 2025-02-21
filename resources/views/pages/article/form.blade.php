<x-page.form
        title="{{ $article->exists ? __('Update :name', ['name' => __(config('admix-articles.name'))]) : __('Create :name', ['name' => __(config('admix-articles.name'))]) }}">
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.label for="form.is_active">
                {{ str(__('admix-articles::fields.is_active'))->ucfirst() }}
            </x-form.label>
            <x-form.toggle name="form.is_active"
                           :large="true"
                           :label-on="__('Yes')"
                           :label-off="__('No')"
            />
        </div>
        <div class="col-md-6 mb-3">
            <x-form.label for="form.is_active">
                {{ str(__('admix-articles::fields.star'))->ucfirst() }}
            </x-form.label>
            <x-form.toggle name="form.star"
                           :large="true"
                           :label-on="__('Yes')"
                           :label-off="__('No')"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.input name="form.name" :label="__('admix-articles::fields.name')" required/>
        </div>
        @if(config('admix-articles.author'))
            <div class="col-md-6 mb-3">
                <x-form.input name="form.author" :label="__('admix-articles::fields.author')" required/>
            </div>
        @endif
        @if(config('admix-articles.call'))
            <div class="col-md-6 mb-3">
                <x-form.input name="form.call" :label="__('admix-articles::fields.call')" required/>
            </div>
        @endif
        @if(config('admix-articles.short_description'))
            <div class="col-md-6 mb-3">
                <x-form.input name="form.short_description" :label="__('admix-articles::fields.short_description')"/>
            </div>
        @endif
        @if(config('admix-articles.video'))
            <div class="col-md-6 mb-3">
                <x-form.input name="form.video" :label="__('admix-articles::fields.video')"
                              placeholder="Ex. https://youtu.be/NIkJFjaWgi8"/>
            </div>
        @endif
        <div class="col-md-12 mb-3">
            <x-form.easymde name="form.description" :label="__('admix-articles::fields.description')" required/>
        </div>
        @if(config('admix-articles.image'))
            <div class="col-md-12 mb-3">
                <x-form.image name="form.image" :label="__('admix-articles::fields.image')"/>
            </div>
        @endif
        @if(config('admix-articles.gallery'))
            <div class="col-md-12 mb-3">
                <x-form.image-library name="form.gallery" :label="__('admix-articles::fields.gallery')"/>
            </div>
        @endif
        @if(config('admix-articles.published_at'))
            <div class="col-md-6 mb-3">
                <x-form.datetime name="form.published_at" :label="__('admix-articles::fields.published_at')" required/>
            </div>
        @endif
        <div class="col-md-6 mb-3">
            <x-form.number name="form.sort" :label="__('admix-articles::fields.sort')"/>
        </div>
    </div>

    <x-slot:complement>
        @if($article->exists)
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.id')"
                                  :value="$article->id"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.slug')"
                                  :value="$article->slug"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.created_at')"
                                  :value="$article->created_at->format(config('admix.timestamp.format'))"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.updated_at')"
                                  :value="$article->updated_at->format(config('admix.timestamp.format'))"/>
            </div>
        @endif
    </x-slot:complement>
</x-page.form>
