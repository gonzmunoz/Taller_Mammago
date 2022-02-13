<!-- header -->
<header class="site-header header mo-left header-style-1">
    <!-- top bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="dlab-topbar-left"></div>
                <div class="dlab-topbar-right">
                    <ul class="social-bx list-inline pull-right">
                        <li>
                            <a href="https://es-es.facebook.com/IESTrassierraCordoba/">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/IesTrassierra">
                                <i class="fab fa-twitter-square"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- top bar END -->
    <!-- main header -->
    <div class="sticky-header header-curve main-bar-wraper navbar-expand-lg">
        <div class="main-bar bg-primary clearfix ">
            <div class="container clearfix">
                <!-- website logo -->
                <div class="logo-header mostion"><a href="{{ route('index') }}"><img
                            src="{{ assetFtp('images/logo.png') }}"
                            width="193"
                            height="89" alt=""></a></div>
                <!-- nav toggle button -->
                <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                        data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <!-- main nav -->
                <div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
                    <ul class="nav navbar-nav justify-content-center align-items-center">
                        <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'index') ? 'active' : '' }}">
                            <a
                                href="{{ route('index') }}">{{ trans('messages.home') }}</a>
                        </li>
                        @if(session('userLogged'))

                            @if(session('userLogged')['id_tipo_usuario']==1||session('userLogged')['id_tipo_usuario']==2)
                                <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'workers') || str_contains(url()->current(), 'addWorker') ? 'active' : '' }}">
                                    <a
                                        href="javascript:;">{{ trans('messages.workers') }} <i
                                            class="fa fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('listWorkers') }}">{{ trans('messages.listWorkers') }}</a>
                                        </li>
                                        @if(session('userLogged')['id_tipo_usuario']==1)
                                            <li>
                                                <a href="{{ route('addWorker') }}">{{ trans('messages.addWorker') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                                <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'clients') ? 'active' : '' }}">
                                    <a
                                        href="javascript:;">{{ trans('messages.clients') }} <i
                                            class="fa fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('listClients') }}">{{ trans('messages.listClients') }}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'cars') ? 'active' : '' }}">
                                    <a
                                        href="javascript:;">{{ trans('messages.cars') }} <i
                                            class="fa fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('listCars') }}">{{ trans('messages.listCars') }}</a></li>
                                    </ul>
                                </li>
                            @endif

                            @if(session('userLogged')['id_tipo_usuario']!=3)
                                <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'appointments') ? 'active' : '' }}">
                                    <a
                                        href="javascript:;">{{ trans('messages.appointments') }} <i
                                            class="fa fa-chevron-down"></i></a>
                                    @if(session('userLogged')['id_tipo_usuario']==4)
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="{{ route('listClientAppointments') }}">{{ trans('messages.myAppointments') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('makeAppointment') }}">{{ trans('messages.makeAppointment') }}</a>
                                            </li>
                                        </ul>
                                    @else
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="{{ route('listAppointments') }}">{{ trans('messages.listAppointments') }}</a>
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                            @endif

                            @if(session('userLogged')['id_tipo_usuario']!=4)
                                <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'repairs') ? 'active' : '' }}"><a
                                        href="javascript:;">{{ trans('messages.repairs') }} <i
                                            class="fa fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('listRepairs') }}">{{ trans('messages.listRepairs') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            @if(session('userLogged')['id_tipo_usuario']!=3)
                                <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'shop') ? 'active' : '' }}">
                                    <a href="javascript:;">{{ trans('messages.shop') }} <i
                                            class="fa fa-chevron-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('shop' , 'all') }}">{{ trans('messages.articles') }}</a>
                                        </li>
                                        @if(session('userLogged')['id_tipo_usuario']==1 || session('userLogged')['id_tipo_usuario']==2)
                                            <li>
                                                <a href="{{ route('newArticle') }}">{{ trans('messages.addNewArticle') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('listOrders') }}">{{ trans('messages.listOrders') }}</a>
                                            </li>
                                        @endif
                                        @if(session('userLogged')['id_tipo_usuario']==4)
                                            <li class="nav-item dropdown align-items-center"><a
                                                    href="{{ route('myOrders') }}">{{ trans('messages.myOrders') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('cartIndex') }}">{{ trans('messages.myShoppingCart') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                                @if(session('userLogged')['id_tipo_usuario']==4)
                                    <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'cars') ? 'active' : '' }}"><a
                                            href="{{ route('myCars') }}">{{ trans('messages.myCars') }}</a>
                                    </li>
                                    <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'repairs') ? 'active' : '' }}"><a
                                            href="{{ route('listClientRepairs') }}">{{ trans('messages.myRepairs') }}</a>
                                    </li>
                                @endif
                            @endif
                        @endif
                        <li class="nav-item dropdown align-items-center"><a
                                href="javascript:;">{{ trans('messages.language') }} <i
                                    class="fa fa-chevron-down"></i></a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('swap', 'es') }}"><i
                                            class="spain flag align-middle"></i>{{ trans('messages.spanish') }}</a>
                                </li>
                                <li><a href="{{ route('swap', 'en') }}"><i
                                            class="united kingdom flag align-middle"></i>{{ trans('messages.english') }}
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @if(session('userLogged'))
                            <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'myAccount') ? 'active' : '' }}">
                                <a href="javascript:;" class="pt-4 pb-4">
                                    <img src="{{ assetFtp(session('userLogged')['foto']) }}"
                                         class="img-fluid rounded-circle" alt="Responsive image"
                                         style="height: 42px; width: 42px;">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('myAccount') }}">{{ trans('messages.myAccount') }}</a></li>
                                    <li><a href="{{ route('logout') }}">{{ trans('messages.Logout') }}</a></li>
                                </ul>
                            </li>
                            @if(session('userLogged')['id_tipo_usuario']==4)
                                <li class="nav-item dropdown align-items-center {{ str_contains(url()->current(), 'cart') ? 'active' : '' }}">
                                    @if(\Cart::isEmpty())
                                        <a href="{{ route('cartIndex') }}">
                                            <i class="fa" style="font-size:24px">&#xf07a;</i>
                                            <span class='badge badge-warning' id='lblCartCount'>0</span>
                                        </a>
                                    @else
                                        <a href="{{ route('cartIndex') }}">
                                            <i class="fa" style="font-size:24px">&#xf07a;</i>
                                            <span class='badge badge-warning'
                                                  id='lblCartCount'>{{ \Cart::getTotalQuantity() }}</span>
                                        </a>
                                    @endif
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown align-items-center">
                                <a href="javascript:;" class="pt-4 pb-4">
                                    <img src="{{ assetFtp('images/users/user.jpg') }}"
                                         class="img-fluid rounded-circle" alt="Responsive image"
                                         style="height: 42px; width: 42px;">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('login') }}">{{ trans('messages.Login') }}</a></li>
                                    <li><a href="{{ route('register') }}">{{ trans('messages.Sign Up') }}</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- main header END -->
</header>
<!-- header END -->
