<html lang="id">

<!--================================================================================
	Item Name: IAM PRIMA
	Version: 2.0
	Author: Fashah Darullah
	Author URL: http://www.instagram.com/fashahdarullah
================================================================================ -->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msapplication-tap-highlight" content="no">
	<meta name="description" content="IAM PRIMA adalah aplikasi mobile monitoring atlet karya anak indonesia yang digunakan untuk meningkatkan performa atlet dan mempermudah metode kepelatihan">
	<meta name="keywords" content="IAM PRIMA, PRIMA, Aplikasi, Monitoring, Atlet, Indonesia, Performa, AWD Indonesia, AWD">
	<title>IAM PRIMA | Integrated Athlete Monitoring</title>

	<!-- Favicons-->
	<link rel="icon" href="<?php echo base_url()?>appsource/images/favicon/favicon-32x32.png" sizes="32x32">
	<!-- Favicons-->
	<link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>appsource/<?php echo base_url()?>appsource/images/favicon/apple-touch-icon-152x152.png">
	<!-- For iPhone -->
	<meta name="msapplication-TileColor" content="#00bcd4">
	<meta name="msapplication-TileImage" content="<?php echo base_url()?>appsource/<?php echo base_url()?>appsource/images/favicon/mstile-144x144.png">
	<!-- For Windows Phone -->


    <!-- CORE CSS-->    
    <link href="<?php echo base_url()?>appsource/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo base_url()?>appsource/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    
    <link href="<?php echo base_url()?>appsource/js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->    
    <link href="<?php echo base_url()?>appsource/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

    <link href="<?php echo base_url()?>appsource/css/custom/custom.css" rel="stylesheet" />

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="<?php echo base_url()?>appsource/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo base_url()?>appsource/js/plugins/jvectormap/jquery-jvectormap.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo base_url()?>appsource/js/plugins/chartist-<?php echo base_url()?>appsource/js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">

    <link href="<?php echo base_url()?>appsource/js/plugins/fullcalendar/css/fullcalendar.min.css" type="text/css" rel="stylesheet" media="screen,projection">

	<link href="<?php echo base_url()?>appsource/js/plugins/sweetalert/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/jquery-1.11.2.min.js"></script>    
   
</head>

<body>
    <!-- Start Page Loading -->
    <div id="loader-wrapper">
        <div id="loader"></div>        
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->

    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color black" style="padding-bottom:15px">
                <div class="nav-wrapper">
                    <ul class="left">                      
						<li><h1 class="logo-wrapper">
							<a href="#" class="brand-logo darken-1"><img src="<?php echo base_url()?>appsource/images/prima.png" alt="IAM PRIMA" style="width:150px;margin-top:-10px"></a> <span class="logo-text">IAM PRIMA</span>
						</h1></li>
                    </ul>
                    <div class="header-search-wrapper hide-on-med-and-down">
                        <i class="mdi-action-search"></i>
                        <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize"/>
                    </div>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>
    <!-- END HEADER -->

    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!-- START MAIN -->
    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">

            <!-- START LEFT SIDEBAR NAV-->
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                <li class="user-details black darken-4">
                    <div class="row" style="margin-left:-20px">
                        <div class="col col s5" style="margin-left:20px">
                            <a href="<?php echo base_url()?>account">
                                <img src="<?php echo $gambar?>" alt="" class="circle responsive-img valign profile-image">
                            </a>
                        </div>
                        <div class="col col s12 m12" style="background:rgba(0,0,0,0.4);margin-top:15px;margin-bottom:-15px">
                            <ul id="profile-dropdown" class="dropdown-content">
                                <li><a href="<?php echo base_url()?>account"><i class="mdi-action-face-unlock"></i> Account</a>
                                </li>
                                <li><a href="<?php echo base_url()?>profile"><i class="mdi-action-perm-identity"></i> Profile</a>
                                </li>
                            </ul>
                            <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown" style="margin-left:20px">
                                <?php echo $name ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                            <p class="user-roal" style="margin-left:20px"><?php echo $role_name ?></p>
                        </div>
                    </div>
                </li>
                <li class="bold"><a href="<?php echo base_url()?>home" class="waves-effect waves-cyan"><i class="mdi-action-view-carousel"></i> Highlights</a>
                </li>
                <li class="bold"><a href="<?php echo base_url()?>dashboard" class="waves-effect waves-cyan"><i class="mdi-action-assignment"></i> Dashboard</a>
                </li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-bookmark"></i> Modules</a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url()?>wellness" class="waves-effect">
										<i><img style="margin-top:8px" width="30px" src="<?php echo base_url()?>appsource/icon/wellness_black.png"/>
										</i> Wellness
									</a></li>
                                    <li><a href="<?php echo base_url()?>training" class="waves-effect">
										<i><img style="margin-top:8px" width="30px" src="<?php echo base_url()?>appsource/icon/monotony_black.png"/>
										</i> Training Load
									</a></li>
                                    <li><a href="<?php echo base_url()?>recovery" class="waves-effect">
										<i><img style="margin-top:8px" width="30px" src="<?php echo base_url()?>appsource/icon/recovery_black.png"/>
										</i> Recovery
									</a></li>
                                    <li><a href="<?php echo base_url()?>pmc" class="waves-effect">
										<i><img style="margin-top:8px" width="30px" src="<?php echo base_url()?>appsource/icon/pmc_black.png"/>
										</i> PMC
									</a></li>
                                    <li><a href="<?php echo base_url()?>profiling" class="waves-effect">
										<i><img style="margin-top:8px" width="30px" src="<?php echo base_url()?>appsource/icon/chart_black.png"/>
										</i> Profiling
									</a></li>
                                    <li><a href="<?php echo base_url()?>mealplan" class="waves-effect">
										<i><img style="margin-top:8px" width="30px" src="<?php echo base_url()?>appsource/icon/meal_black.png"/>
										</i> Meal Plan
									</a></li>
                                </ul>
                            </div>
                        </li>
						<hr>
						<li><a href="<?php echo base_url()?>login/signout"><i class="mdi-navigation-arrow-back"></i> Sign Out</a></li>
                    </ul>
                </li>
            </ul>
                <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
            </aside>
            <!-- END LEFT SIDEBAR NAV-->

            <!-- //////////////////////////////////////////////////////////////////////////// -->

            <!-- START CONTENT -->
            <section id="content">

                <!--start container-->
                <?php $this->load->view($pages) ?>
                
                <?php
                    $menu = "";
                    if($role_type == "KSC" OR $role_type == "CHC"){
                        $menu .= '
                            <li><a href="'.base_url().'createTraining" class="btn-floating red darken-1">
                            <img style="margin-top:8px" width="20px" src="'.base_url().'appsource/icon/monotony.png"/></a>Load</li>
                        ';
                    }if($role_type == "ATL"){
                       $menu .= '
                            <li><a href="'.base_url().'createWellness" class="btn-floating red darken-1">
                            <img style="margin-top:8px" width="20px" src="'.base_url().'appsource/icon/wellness.png"/></a>Wellness</li>
                            <li><a href="'.base_url().'createRecovery" class="btn-floating blue darken-1">
                            <img style="margin-top:8px" width="20px" src="'.base_url().'appsource/icon/recovery.png"/></a>Recovery</li>
                        ';
                    }if($role_type == "CHC" OR $role_type == "KSC"){
                       $menu .= '
                            <li><a href="'.base_url().'createProfiling" class="btn-floating red darken-1">
                            <img style="margin-top:8px" width="20px" src="'.base_url().'appsource/icon/chart.png"/></a>Profiling</li>
                            <li><a href="'.base_url().'pmc" class="btn-floating red darken-1">
                            <img style="margin-top:8px" width="20px" src="'.base_url().'appsource/icon/pmc.png"/></a>PMC</li>
                        ';
                    }
                ?>

                <?php if($role_type == "CHC" OR $role_type == "KSC" OR $role_type == "ATL") { ?>
				<!-- Floating Action Button -->
				<div class="fixed-action-btn" style="bottom: 20px; right: 19px;">
					<a class="btn-floating btn-large red">
					  <i class="mdi-content-add"></i>
					</a>
					<ul>
						<?php echo $menu ?>
					</ul>
				</div>
                <?php } ?>
				<!-- Floating Action Button -->
            <!-- END CONTENT -->

        </div>
        <!-- END WRAPPER -->

    </div>
    <!-- END MAIN -->



    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!-- START FOOTER -->
    <footer class="page-footer">
        <div class="container">
            <div class="row section">
                <div class="col l4 offset-l2 s12">
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                Copyright © <?php echo date("Y")?> <a class="grey-text text-lighten-4" href="http://iamprima.com" target="_blank">IAM PRIMA</a> All rights reserved.
                <span class="right"> Design and Developed by <a class="grey-text text-lighten-4" href="http://iamprima">Team IAM PRIMA</a></span>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->


    <!-- ================================================
    Scripts
    ================================================ -->
    
    <!-- jQuery Library -->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/jquery-1.11.2.min.js"></script>    
    <!--materialize js-->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/materialize.min.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/jquery.form.js"></script>      
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/imagesloaded.pkgd.min.js"></script> 
    <!-- data-tables -->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/data-tables/data-tables-script.js"></script>  
    
    <!-- Calendar Script -->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/fullcalendar/lib/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/fullcalendar/js/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/fullcalendar/fullcalendar-script.js"></script>

	<script src="<?php echo base_url();?>appsource/highcharts/highcharts.js"></script>
	<script src="<?php echo base_url();?>appsource/highcharts/highcharts-more.js"></script>
	<script src="<?php echo base_url();?>appsource/highcharts/modules/exporting.js"></script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/sweetalert/sweetalert.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/custom-script.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/ajaxUrl.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/appjs.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/appaccount.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/appprofile.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/moduleWellness.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/moduleMonotony.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/moduleProfiling.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/moduleRecovery.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/modulePMC.js"></script>
</body>
</html>