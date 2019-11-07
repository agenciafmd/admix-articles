@can('view', '\Agenciafmd\Articles\Article')
    <li class="nav-item">
        <a class="nav-link {{ (admix_is_active(route('admix.articles.index'))) ? 'active' : '' }}"
           href="{{ route('admix.articles.index') }}"
           aria-expanded="{{ (admix_is_active(route('admix.articles.index'))) ? 'true' : 'false' }}">
        <span class="nav-icon">
            <i class="icon {{ config('admix-articles.icon') }}"></i>
        </span>
            <span class="nav-text">
            {{ config('admix-articles.name') }}
        </span>
        </a>
    </li>
@endcan
