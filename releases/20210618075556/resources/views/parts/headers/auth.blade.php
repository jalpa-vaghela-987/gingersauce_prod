<header class="auth">
    <nav class="navbar navbar-expand-md navbar-light bg-white">
        <div class="col-3 h-100 p-0">
            <div class="brand-logo-block text-center h-100">
                <a class="navbar-brand bg-white" href="{{ url('/') }}">
                    <svg width="49" height="50" viewBox="0 0 49 50" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0" y="0" width="49" height="50" fill="#EE6636"/>
                        <path
                            d="M-1 0V50H49V0H-1ZM27.8015 42.03C21.49 43.105 14.764 41.5165 9.487 37.088L13.95 31.7675C17.9335 35.1105 23.1055 36.105 27.801 34.9305V42.03H27.8015ZM27.8015 16.256C26.85 15.234 25.498 14.5905 23.994 14.5905C21.122 14.5905 18.7855 16.927 18.7855 19.798C18.7855 22.67 21.1215 25.007 23.994 25.007C25.4975 25.007 26.8495 24.363 27.8015 23.341V31.3315C26.6025 31.729 25.3245 31.951 23.994 31.951C17.293 31.951 11.841 26.4995 11.841 19.7975C11.841 13.097 17.293 7.6455 23.994 7.6455C25.3245 7.6455 26.602 7.8675 27.8015 8.265V16.256Z"
                            fill="#fff"/>
                    </svg>
                </a>
                <a href="/my/new" class="header-add-new d-none btn btn-danger rounded-0 h-100"
                   style="position: absolute;right: 0;display: block;top: 0;bottom: 0;width: calc(100% - 50px);">
                    <svg width="31" height="29" viewBox="0 0 31 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M18.1597 0.315796H13.1736V12.1699H0.708252V16.9115H13.1736V28.7658H18.1597V16.9115H30.6251V12.1699H18.1597V0.315796Z"
                              fill="white"/>
                    </svg>
                    <span class="d-inline">{{trans('general.create_new')}}</span>
                </a>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <svg viewBox="0 0 30 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="30" height="2" rx="1" fill="#EE6636"/>
                <rect y="10" width="30" height="2" rx="1" fill="#EE6636"/>
            </svg>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="{{route('brandbook.my')}}" class="nav-link">{{__('My Brandbooks')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('profile.plans-pricing')}}" data-toggle="modal" data-target="#modal-buy-plan" class="nav-link bg-success text-white" style="border-radius: 30px;">{{__('Purchase Now')}}</a>
                </li>
                <li class="nav-item d-none">
                    @if(Auth::user()->credits()>0)
                        @if('brandbook.my'==Route::currentRouteName())
                            <router-link to="/my/new" class="nav-link btn btn-danger">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0H5V5H0V7H5V12H7V7H12V5H7V0Z"
                                          fill="white"/>
                                </svg>
                                <span>{{__('Create')}}</span></router-link>
                        @else
                            <a href="{{route('brandbook.my')}}/new" class="nav-link btn btn-danger">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0H5V5H0V7H5V12H7V7H12V5H7V0Z"
                                          fill="white"/>
                                </svg>
                                <span>{{__('Create')}}</span></a>
                        @endif
                    @else
                        <a href="{{route('profile.plans-pricing')}}" class="nav-link btn btn-danger">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0H5V5H0V7H5V12H7V7H12V5H7V0Z"
                                      fill="white"/>
                            </svg>
                            <span>{{__('Create')}}</span></a>
                    @endif
                </li>
                <li class="nav-item d-none">
                    <a href="" class="nav-link">{{__('Community')}}</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-user">
                <!-- Authentication Links -->
                @guest

                @else
                    <li class="nav-item dropdown pl-0 nav-item-user d-none d-md-block">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle-" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                           style="line-height: 40px;">
                            {{trans('general.get_free_credits')}}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
                             style="width: 300px">
                            <refer-a-friend></refer-a-friend>
                        </div>
                    </li>
                    <li class="nav-item package-block">
                        <strong style="margin-top: 10px;display: block;"><span><span class="font-weight-bold"
                                            id="left_credits">{{Auth::user()->credits()}}</span> {{trans('general.books_left')}}</span></strong>
                    </li>
                    <li class="nav-item dropdown pl-0 nav-item-user">
                        <a id="navbarDropdown" id="username" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{url(Auth::user()->avatar)}}"
                                 class="img-thumbnail border-danger avatar rounded-circle">
                            <span class="text-truncate">{{ Auth::user()->name }}</span> <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right main-menu-block" aria-labelledby="navbarDropdown">
                            <a href="{{route('profile.plans-pricing')}}" class="dropdown-item"><i
                                    class="fas fa-tag"></i>{{__('Plans & Pricing')}}</a>
                            <a href="{{route('profile.my')}}" class="dropdown-item"><i class="fa fa-user"
                                                                                       aria-hidden="true"></i>{{__('My Profile')}}
                            </a>
                            <a href="{{route('profile.plans')}}" class="dropdown-item"><i class="fa fa-list-alt"
                                                                                          aria-hidden="true"></i>{{__('profile.my_plans')}}
                            </a>
                            <a href="{{route('billing.index')}}" class="dropdown-item"><i class="fa fa-credit-card"
                                                                                          aria-hidden="true"></i>{{__('profile.billing')}}
                            </a>
                            <a href="{{route('invoice.index')}}" class="dropdown-item"><i class="fa fa-history"
                                                                                          aria-hidden="true"></i>{{__('profile.purchase_history')}}
                            </a>
                            <a href="#" class="dropdown-item submenu"><i
                                    class="fas fa-globe-americas"></i>{{trans('general.language')}}</a>
                            <div class="dropdown-menu">
                                @foreach(config('app.locales') as $locale)
                                    <a class="dropdown-item"
                                       href="{{route('setLocale', ['lang' => $locale ]) }}">{{$locale}}</a>
                                @endforeach
                            </div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</header>
@push('scripts')


@endpush