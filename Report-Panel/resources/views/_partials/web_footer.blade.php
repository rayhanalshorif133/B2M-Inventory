    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <footer id="footer-menu-panel">
                    <nav class="navbar-expand fixed-bottom">
                        <ul class="navbar footer-body">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('category') }}">
                                    <!-- <i class="fas fa-chess fa-2x"></i> -->
                                    <span class="material-symbols-outlined" style="font-size: 2rem;">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('home') }}">
                                    <i class="fas fa-home fa-2x"></i>
                                </a>
                            </li>
                            </li>
                            <li class="nav-item">
                                @if (Auth::check())
                                    <a class="nav-link" aria-current="page" href="{{ route('account') }}">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                @else
                                    <a class="nav-link" aria-current="page" href="#" data-toggle="modal"
                                    data-target="#loginModel">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </nav>

                </footer>
            </div>
        </div>
    </div>
