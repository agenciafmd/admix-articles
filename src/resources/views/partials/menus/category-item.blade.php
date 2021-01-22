@can('view', [
    \Agenciafmd\Articles\Models\Category::class,
    \Agenciafmd\Articles\Models\Article::class,
])
    <li class="nav-item">
        <a class="nav-link {{ (Str::startsWith(request()->route()->getName(), 'admix.articles')) ? 'active' : '' }}"
           href="#sidebar-articles" data-toggle="collapse" data-parent="#menu" role="button"
           aria-expanded="{{ (Str::startsWith(request()->route()->getName(), 'admix.articles')) ? 'true' : 'false' }}">
            <span class="nav-icon">
                <i class="icon {{ config('admix-articles.icon') }}"></i>
            </span>
            <span class="nav-text">
                {{ config('admix-articles.name') }}
            </span>
        </a>
        <div class="navbar-subnav collapse {{ (Str::startsWith(request()->route()->getName(), 'admix.articles')) ? 'show' : '' }}"
             id="sidebar-articles">
            <ul class="nav">
                @can('view', \Agenciafmd\Articles\Models\Category::class)
                    <li class="nav-item">
                        <a class="nav-link {{ (Str::startsWith(request()->route()->getName(), 'admix.articles.categories')) ? 'active' : '' }}"
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
                @can('view', \Agenciafmd\Articles\Models\Article::class)
                    <li class="nav-item">
                        <a class="nav-link {{ (Str::startsWith(request()->route()->getName(), 'admix.articles') && !Str::startsWith(request()->route()->getName(), 'admix.articles.categories')) ? 'active' : '' }}"
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
