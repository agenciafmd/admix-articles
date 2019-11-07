@if (!((admix_cannot('view', '\Agenciafmd\Articles\Article')) && (admix_cannot('view', '\Agenciafmd\Articles\Category'))))
    <li class="nav-item">
        <a class="nav-link @if (admix_is_active(route('admix.articles.index')) || admix_is_active(route('admix.articles.categories.index'))) active @endif"
           href="#sidebar-articles" data-toggle="collapse" data-parent="#menu" role="button"
           aria-expanded="{{ (admix_is_active(route('admix.articles.index')) || admix_is_active(route('admix.articles.categories.index'))) ? 'true' : 'false' }}">
            <span class="nav-icon">
                <i class="icon {{ config('admix-articles.icon') }}"></i>
            </span>
            <span class="nav-text">
                {{ config('admix-articles.name') }}
            </span>
        </a>
        <div
            class="navbar-subnav collapse @if (admix_is_active(route('admix.articles.index')) || admix_is_active(route('admix.articles.categories.index')) ) show @endif"
            id="sidebar-articles">
            <ul class="nav">
                @can('view', '\Agenciafmd\Articles\Category')
                    <li class="nav-item">
                        <a class="nav-link {{ admix_is_active(route('admix.articles.categories.index')) ? 'active' : '' }}"
                           href="{{ route('admix.articles.categories.index') }}">
                            <span class="nav-icon">
                                <i class="icon fe-minus"></i>
                            </span>
                            <span class="nav-text">
                                {{ config('admix-categories.articles-categories.name') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('view', '\Agenciafmd\Articles\Article')
                    <li class="nav-item">
                        <a class="nav-link {{ admix_is_active(route('admix.articles.index')) ? 'active' : '' }}"
                           href="{{ route('admix.articles.index') }}">
                            <span class="nav-icon">
                                <i class="icon fe-minus"></i>
                            </span>
                            <span class="nav-text">
                                {{ config('admix-articles.name') }}
                            </span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>
@endif
