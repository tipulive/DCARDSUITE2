<div class="app-sidebar sidebar-shadow bg-vicious-stance sidebar-text-light">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                        <li class="app-sidebar__heading">Dashboard</li>
                        <li class="app-sidebar__heading d-none show_mobile_only"><img width="42" class="rounded-circle" src="dashboard/assets//images/avatars/1.jpg" alt=""> <span class="name">Profile</span><div class="platform pt-1"></div></li>
                                <li>
                                    <a href="#Forms_Home" onclick="dynamic_menu('Forms_Home')">
                                    <i class="metismenu-icon pe-7s-display2"></i>                   
                                    Home
                                    </a>
                                </li>
                        </ul>
                           <!-- <ul class="vertical-nav-menu">-->
                            <!--if condition will start here-->
                            @include('components.Menu.sideSuperUser')
                            @include('components.Menu.sideAdminStandard')
                            @include('components.Menu.sideStandardClient')
                           {{-- 
                            @if(Auth::guard('Admin')->user()->platform==env('Super'))
                            @include('components.Menu.sideSuperUser')
                               
                            @elseif(Auth::guard('Admin')->user()->platform==env('Standard'))
                            @include('components.Menu.sideAdminUser')

                            @else
                            @include('components.Menu.sideStandardUser')
                             
                            @endif
                           --}} 
                            <!--   <li class="app-sidebar__heading">Widgets</li>
                                <li>
                                    <a href="dashboard-boxes.html">
                                        <i class="metismenu-icon pe-7s-display2"></i>
                                        Dashboard Boxes
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Forms</li>
                                <li>
                                    <a href="forms-controls.html">
                                        <i class="metismenu-icon pe-7s-mouse">
                                        </i>Forms Controls
                                    </a>
                                </li>
                                <li>
                                    <a href="forms-layouts.html">
                                        <i class="metismenu-icon pe-7s-eyedropper">
                                        </i>Forms Layouts
                                    </a>
                                </li>
                                <li>
                                    <a href="forms-validation.html">
                                        <i class="metismenu-icon pe-7s-pendrive">
                                        </i>Forms Validation
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Charts</li>
                                <li>
                                    <a href="charts-chartjs.html">
                                        <i class="metismenu-icon pe-7s-graph2">
                                        </i>ChartJS
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">PRO Version</li>
                                <li>
                                    <a href="https://dashboardpack.com/theme-details/architectui-dashboard-html-pro/" target="_blank">
                                        <i class="metismenu-icon pe-7s-graph2">
                                        </i>
                                        Upgrade to PRO
                                    </a>
                                </li>-->
                           <!--  </ul>-->
                        </div>
                    </div>
                </div> 