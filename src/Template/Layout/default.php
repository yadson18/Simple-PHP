<!DOCTYPE html>
<html lang='pt-br'>
	<head>
		<title><?= $this->fetch('appName') . $this->fetch('title') ?></title>
		
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<?= $this->Html->encoding() ?>

		<?= $this->Html->css('bootstrap.min.css') ?>
		<?= $this->Html->css('font-awesome.min.css') ?>
		<?= $this->Html->less('mixin.less') ?>
		
		<?= $this->Html->script('jquery.min.js') ?>
		<?= $this->Html->script('bootstrap.min.js') ?>

		<?= $this->Html->less('home.less') ?>
		<?= $this->Html->script('less.min.js') ?>
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
 		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
		<style>  
			.navbar {
				margin-bottom: 0;
				background-color: #f4511e;
				z-index: 9999;
				border: 0;
				font-size: 12px !important;
				line-height: 1.42857143 !important;
				letter-spacing: 4px;
				border-radius: 0;
				font-family: Montserrat, sans-serif;
			}
			.navbar li a, .navbar .navbar-brand {
				color: #fff !important;
			}
			.navbar-nav li a:hover, .navbar-nav li.active a {
				color: #f4511e !important;
				background-color: #fff !important;
			}
			.navbar-default .navbar-toggle {
				border-color: transparent;
				color: #fff !important;
			}
			footer .glyphicon {
				font-size: 20px;
				margin-bottom: 20px;
				color: #f4511e;
			}
			.slideanim {visibility:hidden;}
			.slide {
				animation-name: slide;
				-webkit-animation-name: slide;
				animation-duration: 1s;
				-webkit-animation-duration: 1s;
				visibility: visible;
			}
			@keyframes slide {
				0% {
					opacity: 0;
					transform: translateY(70%);
				} 
				100% {
					opacity: 1;
					transform: translateY(0%);
				}
			}
			@-webkit-keyframes slide {
				0% {
					opacity: 0;
					-webkit-transform: translateY(70%);
				} 
				100% {
					opacity: 1;
					-webkit-transform: translateY(0%);
				}
			}
			@media screen and (max-width: 768px) {
				.col-sm-4 {
					text-align: center;
					margin: 25px 0;
				}
				.btn-lg {
					width: 100%;
					margin-bottom: 35px;
				}
			}
			@media screen and (max-width: 480px) {
				.logo {
					font-size: 150px;
				}
			}
		</style>
	</head>
	<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">	
		<nav class="navbar navbar-default navbar-fixed-top">
  			<div class="container">
    			<div class="navbar-header">
      				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        				<span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>                        
      				</button>
      				<a class="navbar-brand" href="#myPage">Logo</a>
    			</div>
    			<div class="collapse navbar-collapse" id="myNavbar">
			      	<ul class="nav navbar-nav navbar-right">
				        <li><a href="#about">ABOUT</a></li>
				        <li><a href="#services">SERVICES</a></li>
				        <li><a href="#portfolio">PORTFOLIO</a></li>
				        <li><a href="#pricing">PRICING</a></li>
				        <li><a href="#contact">CONTACT</a></li>
			      	</ul>
    			</div>
  			</div>
		</nav>
		<div class='content'>
			<?= $this->fetch('content') ?>
		</div>
		<footer class="container-fluid text-center">
  			<a href="#myPage" title="To Top">
    			<span class="glyphicon glyphicon-chevron-up"></span>
  			</a>
  			<p>
  				Bootstrap Theme Made By 
  				<a href="https://www.w3schools.com" title="Visit w3schools">www.w3schools.com</a>
  			</p>
		</footer>
		<script>
			$(document).ready(function(){
			  // Add smooth scrolling to all links in navbar + footer link
			  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
			    // Make sure this.hash has a value before overriding default behavior
			    if (this.hash !== "") {
			      // Prevent default anchor click behavior
			      event.preventDefault();

			      // Store hash
			      var hash = this.hash;

			      // Using jQuery's animate() method to add smooth page scroll
			      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
			      $('html, body').animate({
			      	scrollTop: $(hash).offset().top
			      }, 900, function(){
			      	
			        // Add hash (#) to URL when done scrolling (default click behavior)
			        window.location.hash = hash;
			    });
			    } // End if
			});
			  
			  $(window).scroll(function() {
			  	$(".slideanim").each(function(){
			  		var pos = $(this).offset().top;

			  		var winTop = $(window).scrollTop();
			  		if (pos < winTop + 600) {
			  			$(this).addClass("slide");
			  		}
			  	});
			  });
			})
		</script>
	</body>
</html>