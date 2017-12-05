<!DOCTYPE html>
<html lang="pt-br">
    <head>
    	<title><?= $this->getAppName() ?> Danied Access</title>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

    	<?= $this->Html->css("bootstrap.min.css") ?>
        <?= $this->Html->css("font-awesome.min.css") ?>
        
        <style type="text/css">
            #danied-access{
                background-color: #333;
                padding-top: 10em;
                text-align: center;
            }
            #info h1{
                font-size: 5em;
            }
            #info h1 i{
                color: #f9d821;
            }
            p{
                color: white;
                font-size: 2em; 
            }
            #action{
                margin-top: 30px;
            }
        </style>
    </head>
    <body id="danied-access">
    	<div>
            <div id="info">
                <h1>
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
                </h1>
                <p>You don't have permission to access this page.</p>
            </div>
            <p id="action">
                Make sure the url you typed is correct or
                <a href="/Example/home" class="btn btn-success btn-lg">Click here to make login</a>
            </p>
       	</div>
    </body>
</html>