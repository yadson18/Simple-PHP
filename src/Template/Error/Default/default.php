<!DOCTYPE html>
<html lang="pt-br">
    <head>
    	<title><?= $title ?></title>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

    	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    	<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
        
        <style type="text/css">
            body{
                background-color: #333;
                padding-top: 10em;
                text-align: center;
                color: white;
            }
            #info h1{ font-size: 5em }

            #info h1 i{ color: #f9d821 }

            #action{ margin-top: 30px }
            
            p{ font-size: 2em }
        </style>
    </head>
    <body>
    	<div class="content">
            <?= $this->showTemplate() ?>
       	</div>
    </body>
</html>