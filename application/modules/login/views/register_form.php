<?php
	$query	= $this->db->query("SELECT * FROM master_provinsi ORDER BY provinsi_id ASC");
	if($query->num_rows()>0){
		$opt = "";
		foreach($query->result() as $row){
			$provinsi_id	= $row->provinsi_id;
			$provinsi_nm	= $row->provinsi_nama;
			$opt	.= "<option value='$provinsi_id'>$provinsi_nm</option>"; 
		}
	}else{
		$opt = "<option>No Option Available</option>";
	}
?>
<!DOCTYPE html>
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
	<link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>appsource/images/favicon/apple-touch-icon-152x152.png">
	<!-- For iPhone -->
	<meta name="msapplication-TileColor" content="#00bcd4">
	<meta name="msapplication-TileImage" content="<?php echo base_url()?>appsource/images/favicon/mstile-144x144.png">
	<!-- For Windows Phone -->


	<!-- CORE CSS-->

	<link href="<?php echo base_url()?>appsource/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="<?php echo base_url()?>appsource/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<!-- Custome CSS-->    
	<link href="<?php echo base_url()?>appsource/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="<?php echo base_url()?>appsource/css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

	<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
	<link href="<?php echo base_url()?>appsource/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
	<link href="<?php echo base_url()?>appsource/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  
	<link href="<?php echo base_url()?>appsource/js/plugins/sweetalert/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>

<body class="cyan">
    <!-- Start Page Loading -->
    <div id="loader-wrapper">
        <div id="loader"></div>        
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->
    <div class="row">
        <div class="col s12 l12 card">
            <form class="" id="registerForm">
                <div class="row">
                    <div class="input-field col s12 center">
                    <h4>Register</h4>
                    <p class="center">Join to IAM PRIMA now !</p>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                    <i class="mdi-social-person-outline prefix"></i>
                    <input id="full_name" type="text" maxlength="250" required>
                    <label for="full_name" class="center-align">Nama Lengkap</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                    <i class="mdi-action-event prefix"></i>
                    <input type="date" class="datepicker" id="birth" required>
                    <label for="birth" class="center-align">Tanggal Lahir</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                    <i class="mdi-communication-email prefix"></i>
                    <input id="email" type="email" maxlength="100" required>
                    <label for="email" class="center-align">Email</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s2 l2 m2">
                        <i class="mdi-maps-pin-drop prefix"></i>
                    </div>
                    <div class="input-field col s10 l10 m10">
                       <select id="provinsi" class="browser-default js--animations" required>
                            <?php echo $opt ?>
                        </select>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-action-accessibility prefix"></i>
                        <input id="gender1" name="gender" type="radio" value="male" checked/>
                        <label for="gender1">Pria</label>
                        &nbsp
                        <input id="gender2" name="gender" type="radio" value="female" />
                        <label for="gender2">Wanita</label>
                    </div>
                </div><br>
                <div class="row margin">
                    <div class="input-field col s12">
                    <i class="mdi-social-person-outline prefix"></i>
                    <input id="username" type="text" maxlength="50" required>
                    <label for="username" class="center-align">Username</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                    <i class="mdi-action-lock-outline prefix"></i>
                    <input id="password" type="password" required>
                    <label for="password">Password</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                    <i class="mdi-communication-vpn-key prefix"></i>
                    <input id="licence" type="text">
                    <label for="licence">Licence Code</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light col s12">Register Now</button>
                    </div>
                    <div class="input-field col s12">
                        <p class="margin center medium-small sign-up">Already have an account? <a href="<?php echo base_url()?>login/form">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>



  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo base_url()?>appsource/js/materialize.min.js"></script>
  <!--prism-->
  <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/prism/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

      <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/plugins/sweetalert/sweetalert.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/custom-script.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/ajaxUrl.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>appsource/js/modules/applogin.js"></script>

</body>
</html>
<script>
    $(function() {
        $('#username').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });
</script>