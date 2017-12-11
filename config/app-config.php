<?php 
	use Simple\Configurator\Configurator;

	$config = Configurator::getInstance();

	$config
	
		->set('App', [
			'name' => 'Simple - ',
			'displayErrors' => true,
			'encoding' => 'utf-8',
			'timezone' => 'UTC',
			'locate' => 'pt-Br',
			'errorPage' => 'danied-access.php'
		])

		->set('Routes', [
			'default' => [
				'controller' => 'Page', 
				'view' => 'home'
			]
		])

		->set('Email', [
			'default' => [
				'host' => 'smtp.gmail.com',
				'port' => 587,
				'email' => 'example@email.com',
				'password' => 'secret',
				'security' => 'tls'
			]
		])

		->set('Databases', [
			'databaseType' => [
				'databaseName' => [
					'host' => 'localhost',
					'path' => 'pathName',
					'user' => 'root',
					'password' => 'secret',
					'encoding' => 'UTF8'
				]
			]
		])

		->set('Webservice', [
			'url' => "example.com/soap",
			'configs' => [
				'soap_version' => 'SOAP_1_2',
                'exceptions' => true,
                'trace' => 1,
                'cache_wsdl' => 'WSDL_CACHE_NONE',
                'stream_context' => stream_context_create([
                	'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT
                    ]
                ])
			]
		]);	