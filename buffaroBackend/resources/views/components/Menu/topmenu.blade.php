<div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src">
                    
                </div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar" >
                            <span class="hamburger-box">
                                <span class="hamburger-inner" onclick="return menu_open()"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner" onclick="return menu_open()"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn  btn-sm mobile-toggle-header-nav mob_menu_btn">
                    <span class="btn-icon-wrapper position-relative mrl-2 mob_not">
                        <a href="#" type="button" class="btn-shadow p-1  btn-sm show-toastr-example " onclick="get_newnotification_order()">
                                        <i class="fa text-white text-primary fa-bell  pr-1 pl-1"></i>
                                    </a>
                                    <div class="position-absolute notification_counter text-danger"></div>
                        </span>
                    
                    <a href="logout" type="button" class="btn-shadow p-1 btn btn-danger btn-sm show-toastr-example ">
                                        <i class="fa text-white fa-power-off  pr-1 pl-1"></i>
                                    </a>
                        
                    </button>
                </span>
            </div>   
            
             <div class="app-header__content">
                <div class="app-header-left">
                    <div class="search-wrapper d-none">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                    <ul class="header-menu nav d-none">
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-database"> </i>
                                Statistics
                            </a>
                        </li>
                        <li class="btn-group nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-edit"></i>
                                Projects
                            </a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li>
                    </ul>        </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="dashboard/assets//images/avatars/1.jpg" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8 d-none"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                            <button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                            <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                            <button type="button" tabindex="0" class="dropdown-item">Actions</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <button type="button" tabindex="0" class="dropdown-item">Dividers</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading name">
                                  <!--Auth Name assign to class name -->
                                    </div>
                                    <div class="widget-subheading platform">
                                      
                                          <!--Auth platform assign to class Platfom -->
                                    </div>
                                </div>
                               <!--Notification-->
                               <div class="widget-content-right header-user-info ml-3">
                                    <a href="logout" type="button" class="btn-shadow p-1 btn btn-danger btn-sm show-toastr-example">
                                        <i class="fa text-white fa-power-off  pr-1 pl-1"></i>
                                    </a>

                                </div>
                               <div class="notifications d-none ">
    
        
        <div class="notification_dd">
            <ul class="notification_ul">
                <li class="starbucks success mouseover d-none">
                    <div class="notify_icon">
                        <span class="icon"><img width="42" class="rounded-circle" src="dashboard/assets//images/avatars/1.jpg" alt=""></span>  
                    </div>
                    <div class="notify_data">
                        <div class="title">
                            Lorem, ipsum dolor.  
                        </div>
                        <div class="sub_title">
                         <button class="btn btn-primary">Accept</button> <button class="btn btn-primary">Reject</button>
                        
                      </div>
                    </div>
                    <div class="notify_status">
                        <p> <button class="btn btn-primary">View</button></p>  
                    </div>
                </li>  
                <li class="baskin_robbins failed mouseover  d-none">
                    <div class="notify_icon">
                        <span class="icon">   <img width="42" class="rounded-circle" src="dashboard/assets//images/avatars/1.jpg" alt=""></span>  
                    </div>
                    <div class="notify_data">
                        <div class="title">
                            Lorem, ipsum dolor.  
                        </div>
                        <div class="sub_title">
                          Lorem ipsum dolor sit amet consectetur.
                      </div>
                    </div>
                    <div class="notify_status">
                        <p>Failed</p>  
                    </div>
                </li> 
                <li class="mcd success mouseover  d-none">
                    <div class="notify_icon">
                        <span class="icon"><img width="42" class="rounded-circle" src="dashboard/assets//images/avatars/1.jpg" alt=""></span>  
                    </div>
                    <div class="notify_data">
                        <div class="title">
                            Lorem, ipsum dolor.  
                        </div>
                        <div class="sub_title">
                          Lorem ipsum dolor sit amet consectetur.
                      </div>
                    </div>
                    <div class="notify_status">
                        <p>Success</p>  
                    </div>
                </li>  
                <li class="pizzahut failed mouseover  d-none">
                    <div class="notify_icon">
                        <span class="icon"></span>  
                    </div>
                    <div class="notify_data">
                        <div class="title">
                            Lorem, ipsum dolor.  
                        </div>
                        <div class="sub_title">
                          Lorem ipsum dolor sit amet consectetur.
                      </div>
                    </div>
                    <div class="notify_status">
                        <p>Failed</p>  
                    </div>
                </li> 
                <li class="kfc success mouseover  d-none">
                    <div class="notify_icon">
                        <span class="icon"></span>  
                    </div>
                    <div class="notify_data">
                        <div class="title">
                            Lorem, ipsum dolor.  
                        </div>
                        <div class="sub_title">
                          Lorem ipsum dolor sit amet consectetur.
                      </div>
                    </div>
                    <div class="notify_status">
                        <p>Success</p>  
                    </div>
                </li> 
                <li class="show_all">
                    <p class="link" >Show All Notification</p>
                </li> 
            </ul>
        </div>
        
      </div>
                               <!--Notification-->
                              <!-- <div class="widget-content-right header-user-info ml-3 position-relative ">
                               
                               <button type="button" class="btn-shadow p-1 btn  btn-sm " onclick="get_newnotification_order()">
                                   <i class="fa text-primary fa-bell  pr-1 pl-1"></i>
                               </button>
                               <div class="position-absolute notification_counter text-danger"></div>
                           </div>-->


                            </div>
                        </div>
                    </div>        </div>
            </div>
        </div> 