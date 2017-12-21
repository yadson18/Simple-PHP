<!DOCTYPE html>
<html lang='pt-br'>
	<head>
		<title><?= $this->fetch('appName') . $this->fetch('title') ?></title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<?= $this->Html->encoding() ?>

		<?= $this->Html->css('bootstrap.min.css') ?>
		<?= $this->Html->css('fontawesome-all.min.css') ?>

		<?= $this->Html->css('https://fonts.googleapis.com/css?family=Montserrat') ?>
		<?= $this->Html->css('https://fonts.googleapis.com/css?family=Lato') ?>
		
		<?= $this->Html->script('jquery.min.js') ?>
		<?= $this->Html->script('bootstrap.min.js') ?>

		<?= $this->Html->less('mixin.less') ?>

		<?= $this->Html->less('home-page.less') ?>
		<?= $this->Html->script('home-page.js') ?>

		<?= $this->Html->script('less.min.js') ?>
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
  				<div id="top">
	  				<i class="fas fa-angle-up fa-2x"></i>
	  				<p>Voltar ao Topo</p>
  				</div>
  			</a>
  			<p>
  				Bootstrap Theme Made By 
  				<a href="https://www.w3schools.com" title="Visit w3schools">www.w3schools.com</a>
  			</p>
		</footer>
	</body>
</html>