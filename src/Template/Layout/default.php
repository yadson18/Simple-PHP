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
	</head>
	<body>	
		<nav class='navbar navbar-default navbar-fixed-top' id='home-nav'>
		    <div class='container-fluid'>
		        <div class='navbar-header'>
		            <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#responsive-menu' aria-expanded='false'>
		                <span class='sr-only'>Toggle navigation</span>
		                <span class='icon-bar'></span>
		                <span class='icon-bar'></span>
		                <span class='icon-bar'></span>
		            </button>
		        </div>
		        <div class='collapse navbar-collapse' id='responsive-menu'>
		            <ul class='nav navbar-nav navbar-right'>
		            	<li><a href='#'>View More</a></li>
		                <p class='navbar-text'>or</p>
		                <li><a href='#'>Click Here</a></li>
		            </ul>
		        </div>
		    </div>
		</nav>
		<div class='content'>
			<?= $this->fetch('content') ?>
		</div>
	</body>
</html>