<style>
    .header-nav{
        background: #ffa41f;
    }
    .navbar-default{
        border-color: #333;
        background: #333;
    }
    .navbar-default .navbar-nav>li>a{
        color: #fff;
    }
    .navbar-collapse{
        padding-left: 0px;
        padding-right: 0px;
    }
    .social{
        position: fixed;
        float: right;
        list-style-type: none;
        z-index: 9;
        top: 224px;
        left: -12px;
    }
    .social li a img{
        width:80%; height:80%;
    }
</style>
<ul class="social">
    <li><a href=""><img src="assets/images/facebook.jpg" /></a></li>
    <li><a href=""><img src="assets/images/google_plus.png" /></a></li>
    <li><a href=""><img src="assets/images/twitter.png" /></a></li>
    <li><a href=""><img src="assets/images/linkedin.jpg" /></a></li>
</ul>
<div class="clearfix"></div>
<div class="top-bar_w3agileits wow fadeInDown">
			<div class="top-logo_info_w3layouts">
				<div class="col-md-3 logo">
					<!-- <h1><a class="navbar-brand" href="">Rojgar Avsar Yojna<span>For Industry Solutions</span></a></h1> -->
					<img src="images/logo.png" class="img-responsive" />
				</div>
				<div class="col-md-9 adrress_top">
					<div class="adrees_info">
						<div class="col-md-6 visit">
							<div class="col-md-2 col-sm-2 col-xs-2 contact-icon">
								<span class="fa fa-mobile" aria-hidden="true"></span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-10 contact-text">
								<h4>Contact us</h4>
								<p>+91-755 493 4499</p>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-6 mail-us">
							<div class="col-md-2 col-sm-2 col-xs-2 contact-icon">
								<span class="fa fa-envelope" aria-hidden="true"></span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-10 contact-text">
								<h4>Mail us</h4>
								<p><a href="mailto:recruiter@jobshuntconsultancy.com">recruiter@jobshuntconsultancy.com</a></p>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div>
					<!--<ul class="top-right-info_w3ls">-->
					<!--	<li><a href="https://www.facebook.com/jobs.huntbhopal" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>-->
					<!--	<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>-->
					<!--	<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>-->
					<!--</ul>-->
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="header-nav">
				<div class="inner-nav_wthree_agileits">
					<nav class="navbar navbar-default">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
							<nav>
								<ul class="nav navbar-nav">
									<li><a href="index.php" <?php if($_SERVER['REQUEST_URI']=='/index.php' || $_SERVER['REQUEST_URI']=='/'){ ?> class="active" <?php } ?>>Home</a></li>
									<li><a href="aboutus.php" <?php if($_SERVER['REQUEST_URI']=='/aboutus.php'){ ?> class="active" <?php } ?>>About Us</a></li>
									<li><a href="services.php" <?php if($_SERVER['REQUEST_URI']=='/services.php'){ ?> class="active" <?php } ?>>Services</a></li>
									<li><a href="hot-jobs.php" <?php if($_SERVER['REQUEST_URI']=='/hot-jobs.php'){ ?> class="active" <?php } ?>>Hot Jobs</a></li>
									<li><a href="fresher-jobs.php" <?php if($_SERVER['REQUEST_URI']=='/fresher-jobs.php'){ ?> class="active" <?php } ?>>Fresher Jobs</a></li>
									<!--
									<li><a href="registration.php" <?php if($_SERVER['REQUEST_URI']=='/registration.php'){ ?> class="active" <?php } ?>>Registration</a></li>
									-->
									<li><a href="contact.php" <?php if($_SERVER['REQUEST_URI']=='/contact.php'){ ?> class="active" <?php } ?>>Contact Us</a></li>
								</ul>
							</nav>

						</div>
					</nav>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>