<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

    <!-- ============================================== TOP MENU ============================================== -->
    <div class="top-bar animate-dropdown">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled">
                        @auth
                            <li><a href="{{ route('user.owners') }}"><i class="icon fa fa-book"></i>My Owner</a></li>
                            <li><a href="#"><i class="icon fa fa-heart"></i>Wishlist</a></li>
                            <li><a href="{{ route('home') }}"><i class="icon fa fa-user"></i>User Profile</a></li>
                        @else
                            <li><a href="{{ route('login') }}"><i class="icon fa fa-lock"></i>Login/Register</a></li>
                        @endauth

                    </ul>
                </div>
                <!-- /.cnt-account -->
                <!-- /.cnt-cart -->
                <div class="clearfix"></div>
            </div>
            <!-- /.header-top-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.header-top -->
    <!-- ============================================== TOP MENU : END ============================================== -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo"> <a href="home.html"> <img src="assets/images/logo.png" alt="logo"> </a>
                    </div>
                    <!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= -->
                </div>
                <!-- /.logo-holder -->

                <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
                    <!-- /.contact-row -->
                    <!-- ============================================================= SEARCH AREA ============================================================= -->
                    <div class="search-area">
                        <form>
                            <div class="control-group">
                                <input class="search-field" placeholder="Search Product Name Here..." />
                                <a class="search-button" href="#"></a>
                            </div>
                        </form>
                    </div>
                    <!-- /.search-area -->
                    <!-- ============================================================= SEARCH AREA : END ============================================================= -->
                </div>
                <!-- /.top-search-holder -->


            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- /.main-header -->

    <!-- ============================================== NAVBAR ============================================== -->
    <div class="header-nav animate-dropdown">
        <div class="container">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> </button>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">
                                <li class="{{ isset($activeHome) ? $activeHome : '' }} yamm-fw"> <a
                                        href="{{ url('/') }}">Home</a> </li>
                                <li class="dropdown yamm mega-menu"> <a href="#">Mobil</a>
                                </li>
                                <li class="dropdown yamm mega-menu"> <a href="#">Souvenir Papua</a>
                                </li>
                                <li class="dropdown yamm mega-menu"> <a href="#">Agent Traveling</a>
                                </li>
                                <li class="dropdown yamm mega-menu"> <a href="#">Computer</a>
                                </li>
                                <li class="dropdown yamm mega-menu"> <a href="#">Jabar Shop</a>
                                </li>

                            </ul>
                            <!-- /.navbar-nav -->
                            <div class="clearfix"></div>
                        </div>
                        <!-- /.nav-outer -->
                    </div>
                    <!-- /.navbar-collapse -->

                </div>
                <!-- /.nav-bg-class -->
            </div>
            <!-- /.navbar-default -->
        </div>
        <!-- /.container-class -->

    </div>
    <!-- /.header-nav -->
    <!-- ============================================== NAVBAR : END ============================================== -->

</header>

<!-- ============================================== HEADER : END ============================================== -->
<style>
    .navbar-nav .active a {
        background-color: white !important;
        color: black !important;
        border-top-right-radius: 2px;
        border-top-left-radius: 2px;
    }

</style>
