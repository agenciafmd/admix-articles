@can('view', \Agenciafmd\Articles\Models\Article::class)
    <li class="nav-item">
        <a class="nav-link {{ (Str::startsWith(request()->route()->getName(), 'admix.articles')) ? 'active' : '' }}"
           href="{{ route('admix.articles.index') }}"
           aria-expanded="{{ (Str::startsWith(request()->route()->getName(), 'admix.articles')) ? 'true' : 'false' }}">
        <span class="nav-icon">
            <i class="icon {{ config('admix-articles.icon') }}"></i>
        </span>
            <span class="nav-text">
            {{ config('admix-articles.name') }}
        </span>
        </a>
    </li>
@endcan
