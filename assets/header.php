<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <head>
     <title>Noah Education Consultancy</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- LIBRARY FONT-->
     <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,900,300">
     <link type="text/css" rel="stylesheet" href="assets/font/font-icon/font-awesome-4.4.0/css/font-awesome.css">
     <link type="text/css" rel="stylesheet" href="assets/font/font-icon/font-svg/css/Glyphter.css">
     <!-- LIBRARY CSS-->
     <link type="text/css" rel="stylesheet" href="assets/libs/animate/animate.css">
     <link type="text/css" rel="stylesheet" href="assets/libs/bootstrap-3.3.5/css/bootstrap.css">
     <link type="text/css" rel="stylesheet" href="assets/libs/owl-carousel-2.0/assets/owl.carousel.css">
     <link type="text/css" rel="stylesheet" href="assets/libs/selectbox/css/jquery.selectbox.css">
     <link type="text/css" rel="stylesheet" href="assets/libs/fancybox/css/jquery.fancybox.css">
     <link type="text/css" rel="stylesheet" href="assets/libs/fancybox/css/jquery.fancybox-buttons.css">
     <link type="text/css" rel="stylesheet" href="assets/libs/media-element/build/mediaelementplayer.min.css">
     <!-- STYLE CSS    --><!--link(type="text/css", rel='stylesheet', href='assets/css/color-1.css', id="color-skins")-->
     <link type="text/css" rel="stylesheet" href="#" id="color-skins">
     <script src="assets/libs/jquery/jquery-2.1.4.min.js"></script>
     <script src="assets/libs/js-cookie/js.cookie.js"></script>
     <script>if ((Cookies.get('color-skin') != undefined) && (Cookies.get('color-skin') != 'color-1')) {
        $('#color-skins').attr('href', 'assets/css/' + Cookies.get('color-skin') + '.css');
    } else if ((Cookies.get('color-skin') == undefined) || (Cookies.get('color-skin') == 'color-1')) {
        $('#color-skins').attr('href', 'assets/css/color-1.css');
    }


</script>
</head>
<!-- HEADER-->
<header>
    <div class="header-topbar">
        <div class="container">
            <div class="topbar-left pull-left">
                <div class="email"><a href="#"><i class="topbar-icon fa fa-envelope-o"></i><span>info@noah.edu.np</span></a></div>
                <div class="hotline"><a href="#"><i class="topbar-icon fa fa-phone"></i><span>+977-01-4440594</span></a></div>
            </div>
            <!-- <div class="topbar-right pull-right">
                <div class="socials"><a href="#" class="facebook"><i class="fa fa-facebook"></i></a><a href="#" class="google"><i class="fa fa-google-plus"></i></a><a href="#" class="twitter"><i class="fa fa-twitter"></i></a><a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a><a href="#" class="blog"><i class="fa fa-rss"></i></a><a href="#" class="dribbble"><i class="fa fa-dribbble"></i></a></div>
                <div class="group-sign-in"><a href="login.html" class="login">login</a><a href="register.html" class="register">register</a></div>
            </div> -->
        </div>
    </div>
    <div class="header-main homepage-01">
        <div class="container">
            <div class="header-main-wrapper">
                <div class="navbar-heade">
                    <div class="logo pull-left"><a href="index.php" class="header-logo"><img src="assets/images/logo-color-1.png" alt=""/></a></div>
                    <button type="button" data-toggle="collapse" data-target=".navigation" class="navbar-toggle edugate-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <nav class="navigation collapse navbar-collapse pull-right">
                    <ul class="nav-links nav navbar-nav">
                        <li class="dropdown active"><a href="index.php" class="main-menu">Home<span></span></a>
                        </li>
                        <li class="dropdown"><a href="" class="main-menu">About US<span class="fa fa-angle-down icons-dropdown"></span></a>
                            <ul class="dropdown-menu edugate-dropdown-menu-1">
                                <li><a href="about_us.php" class="link-page">About Noah</a></li>
                                <li><a href="mission.php" class="link-page">Mission</a></li>
                                <li><a href="vision.php" class="link-page">Vision</a></li>
                                <!-- <li><a href="service.php" class="link-page">Services</a></li> -->
                            </ul>
                        </li>
                        <li class="dropdown"><a href="javascript:void(0)" class="main-menu">Test Preparation<span class="fa fa-angle-down icons-dropdown"></span></a>
                            <ul class="dropdown-menu edugate-dropdown-menu-1">
                                <li><a href="ielts.php" class="link-page">IELTS</a></li>
                                <li><a href="tofel.php" class="link-page">TOFEL</a></li>
                                <li><a href="sat.php" class="link-page">SAT</a></li>
                                <li><a href="gre.php" class="link-page">GRE</a></li>
                                <li><a href="gmat.php" class="link-page">GMAT</a></li>
                                <li><a href="pte.php" class="link-page">PTE</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="gallery.php" class="main-menu">gallery</a>
                        </li>
                        <li class="dropdown"><a href="javascript:void(0)" class="main-menu">Study Abroad<span class="fa fa-angle-down icons-dropdown"></span></a>
                            <ul class="dropdown-menu edugate-dropdown-menu-1">
                                <li><a href="australia.php" class="link-page">Australia</a></li>
                                <li><a href="korea.php" class="link-page">South Korea</a></li>
                                <li><a href="new_zealand.php" class="link-page">New Zealand</a></li>
                                <li><a href="usa.php" class="link-page">USA</a></li>
                                <li><a href="uk.php" class="link-page">UK</a></li>
                                <li><a href="europe.php" class="link-page">Europe</a></li>
                                <li><a href="canada.php" class="link-page">Canada</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="javascript:void(0)" class="main-menu">Services<span class="fa fa-angle-down icons-dropdown"></span></a>
                            <ul class="dropdown-menu edugate-dropdown-menu-1">
                                <li><a href="free_counseling.php" class="link-page">Free Counseling</a></li>
                                <li><a href="acadmic_counseling.php" class="link-page">Academic Counseling</a></li>
                                <li><a href="visa_assistance.php" class="link-page">Visa Assistance</a></li>
                                <li><a href="financial_assistance.php" class="link-page">Financial Assistance</a></li>
                                <li><a href="service.php" class="link-page">Other Services</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="contact.php" class="main-menu">Contact</a>
                        </li>
                        <li class="button-search"><p class="main-menu"><i class="fa fa-search"></i></p></l>
                            <div class="nav-search hide">
                                <form><input type="text" placeholder="Search" class="searchbox"/>
                                    <button type="submit" class="searchbutton fa fa-search"></button>
                                </form>
                            </div>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</body>
</html>