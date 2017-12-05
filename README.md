Configurações para uso.
	
	Instale o PHP.
		# add-apt-repository ppa:ondrej/php
		# apt-get update
		# apt-get install -y php
	
	Instale o Apache.
		# apt-get install apache2.
	
	Instale um SGBD de sua preferência.
	
	Defina o diretório "webroot" como raíz do projeto nas configurações do Apache.
	
	Habilite o módulo do Apache para reescrita de URL's.
	
	Modifique o arquivo "apache.conf".
		De:
			&lt;Directory /var/www/&gt;
				Options Indexes FollowSymLinks
				AllowOverride None
				Require all danied
			&lt;/Directory&gt;	
					</div>
		Para:
			&lt;Directory /var/www/&gt;
				Options Indexes FollowSymLinks
				AllowOverride All
				Require all granted
			&lt;/Directory&gt;	

	Instale o "php-interbase", caso for usar o "firebird".
		# apt-get install php-interbase
	
	Instale o "php-soap", caso seja necessário o uso de webservices.
		# apt-get install php-soap
	
	Por fim, reinicie o Apache, para carregar as novas configurações.
		# service apache2 restart