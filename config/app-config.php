<?php 
	use Simple\Configurator\Configurator;

	$configurator = Configurator::getInstance();

	$configurator
		->setConfig("AppName", "Example Name - ")
		
		->setConfig("DisplayErrors", true)

		->setConfig("DefaultErrorPage", VIEW."ErrorPages".DS."daniedAccess.php")

		->setConfig("DefaultRoute", [
			"controller" => "Example",
			"view" => "home"
		])

		->setConfig("EmailTransport", [
			"host" => "smtp.gmail.com",
			"port" => 587,
			"email" => "yadsondev@gmail.com",
			"password" => "yadsondado12",
			"security" => "tls"
		])

		->setConfig("Databases", [
			"firebird" => [
				"SRICASH" => [
					"host" => "localhost",
					"path" => "/BD/SRICASH.FDB",
					"user" => "SYSDBA",
					"password" => "masterkey",
					"charsetConfig" => "UTF8"
				]
			]
		])

		->setConfig("Webservice", [
			"url" => "urlExample.com/soap",
			"options" => [
				"soap_version" => "SOAP_1_2",
                "exceptions" => true,
                "trace" => 1,
                "cache_wsdl" => "WSDL_CACHE_NONE",
                "stream_context" => stream_context_create([
                	"ssl" => [
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "crypto_method" => STREAM_CRYPTO_METHOD_TLS_CLIENT
                    ]
                ])
			]
		]);	