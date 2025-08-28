<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Taguig OFW Office</title>
    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/4f2d7302b1.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <!-- Start GA -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->

    <style type="text/css">
    /* Chart.js */
    @-webkit-keyframes chartjs-render-animation {
        from {
            opacity: 0.99
        }

        to {
            opacity: 1
        }
    }

    @keyframes chartjs-render-animation {
        from {
            opacity: 0.99
        }

        to {
            opacity: 1
        }
    }

    .chartjs-render-monitor {
        -webkit-animation: chartjs-render-animation 0.001s;
        animation: chartjs-render-animation 0.001s;
    }
    </style>

    <style type="text/css">
    .jqstooltip {
        position: absolute;
        left: 0px;
        top: 0px;
        visibility: hidden;
        background: rgb(0, 0, 0) transparent;
        background-color: rgba(0, 0, 0, 0.6);
        filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
        color: white;
        font: 10px arial, san serif;
        text-align: left;
        white-space: nowrap;
        padding: 5px;
        border: 1px solid white;
        z-index: 10000;
    }

    .jqsfield {
        color: white;
        font: 10px arial, san serif;
        text-align: left;
    }
    </style>
</head>

<body class="sidebar-show">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg" style="background-color: rgb(131, 17, 21);"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                                <i class="fas fa-bars"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                                <i class="fas fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep">
                            <i class="far fa-envelope"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">
                                Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
                            <i class="far fa-bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">
                                Notifications
                                <div class="float-right">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <div class="d-sm-none d-lg-inline-block">Hi,
                                @auth
                                {{ Auth::user()->first_name }} {{ Auth::user()->middle_name }}
                                {{ Auth::user()->last_name }}
                                @endauth
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged in 5 min ago</div>
                            <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-activities.html" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="submit" value="Logout" class="dropdown-item has-icon text-danger">
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2" tabindex="1" style="overflow: hidden; outline: none;">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}">Taguig OFW OFFICE</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}">OFW</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.dashboard') ? 'active' : '' }}">
                            <a href="{{ route(Auth::user()->getRoleNames()->first().'.dashboard') }}" class="nav-link">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @role('superadmin|admin')
                        <li class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first() . '.applicant.index') ? 'active' : '' }}">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.applicant.index') }}" class="nav-link">
                                <i class="fas fa-folder-open"></i>
                                <span>List of Applicants</span>
                            </a>
                        </li> 
                        <li class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first() . '.user.index') ? 'active' : '' }}">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.user.index') }}" class="nav-link">
                                <i class="fas fa-folder-open"></i>
                                <span>List of Users</span>
                            </a>
                        </li> 
                        <li class="menu-header">Report</li>
                        <li class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first() . '.report.index') ? 'active' : '' }}">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.report.index') }}" class="nav-link">
                                <i class="fas fa-file-pdf"></i>
                                <span>Reports</span>
                            </a>
                        </li>
                        <li class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first() . '.archive.index') ? 'active' : '' }}">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.archive.index') }}" class="nav-link">
                                <i class="fas fa-box-archive"></i>
                                <span>Archive</span>
                            </a>
                        </li>
                        <li class="menu-header">Activity logs</li>
                        <li class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first() . '.activity.log') ? 'active' : '' }}">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.activity.log') }}" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span>User logs</span>
                            </a>
                        </li>
                        @endrole

                        @role('superadmin')
                        <li class="menu-header">CMS</li>@php
                        $role = Auth::user()->getRoleNames()->first();
                        $children = [
                        'gender.index', 'religion.index', 'civil.index', 'educational.index', 'barangay.index',
                        'residence.index', 'typeId.index', 'relation.index', 'owwa.index', 'contract.index',
                        'continent.index',
                        'country.index', 'job.index', 'subJob.index', 'need.index'
                        ];
                        $open = collect($children)
                        ->map(fn($r) => "$role.$r")
                        ->contains(fn($route) => request()->routeIs($route));
                        @endphp

                        <li class="dropdown {{ $open ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown">
                                <i class="fas fa-th"></i>
                                <span>Dropdown options</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.gender.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.gender.index') }}">
                                        <i class="fa-solid fa-person-half-dress"></i>
                                        Gender
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.religion.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.religion.index') }}">
                                        <i class="fa-solid fa-hands-praying"></i>
                                        Religion
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.civil.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.civil.index') }}">
                                        <i class="fa-solid fa-heart"></i>
                                        Civil Status
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.educational.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.educational.index') }}">
                                        <i class="fa-solid fa-book"></i>
                                        Educational Attainemnt
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.barangay.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.barangay.index') }}">
                                        <i class="fa-solid fa-house"></i>
                                        Barangay
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.residence.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.residence.index') }}">
                                        <i class="fa-solid fa-people-line"></i>
                                        Type of residence
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.typeId.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.typeId.index') }}">
                                        <i class="fa-solid fa-id-badge"></i>
                                        Type of ID
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.relation.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.relation.index') }}">
                                        <i class="fa-solid fa-person-breastfeeding"></i>
                                        Relations
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.owwa.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.owwa.index') }}">
                                        <i class="fa-solid fa-plane"></i>
                                        Owwa
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.contract.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.contract.index') }}">
                                        <i class="fa-solid fa-sheet-plastic"></i>
                                        Contract
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.continent.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.continent.index') }}">
                                        <i class="fa-solid fa-globe"></i>
                                        Continent
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.country.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.country.index') }}">
                                        <i class="fa-solid fa-map"></i>
                                        Country
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.job.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.job.index') }}">
                                        <i class="fa-solid fa-briefcase"></i>
                                        Job
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.subJob.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.subJob.index') }}">
                                        <i class="fa-solid fa-suitcase"></i>
                                        Sub Job
                                    </a>
                                </li>
                                <li
                                    class="dropdown {{ request()->routeIs(Auth::user()->getRoleNames()->first().'.need.index') ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route(Auth::user()->getRoleNames()->first() . '.need.index') }}">
                                        <i class="fa-solid fa-bowl-food"></i>
                                        Needs
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                    </ul>
                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-comment"></i> Contact support
                        </a>
                    </div>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content" style="min-height: 635px;">
                <section class="section">
                    @yield('content')
                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright © 2025 <div class="bullet"></div> Information Technology
                </div>
                <div class="footer-right">
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    @stack('modals')
    @stack('scripts')
</body>

</html>