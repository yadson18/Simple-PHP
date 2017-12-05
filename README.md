Configurações para uso.

1 - Instale o PHP.
	# add-apt-repository ppa:ondrej/php
	# apt-get update
	# apt-get install -y php

2 - Instale o Apache.
	# apt-get install apache2

3 - Instale um SGBD de sua preferência.

4 - Defina o diretório "webroot" como raíz do projeto nas configurações do Apache.

5 - Habilite o módulo do Apache para reescrita de URL's.
	# a2enmod rewrite

6 - Modifique o arquivo "apache.conf".
	
	De:
		<Directory /var/www/>
			Options Indexes FollowSymLinks
			AllowOverride None
			Require all danied
		</Directory>

	Para:
		<Directory /var/www/>
			Options Indexes FollowSymLinks
			AllowOverride All
			Require all granted
		</Directory>

7 - Instale o "php-interbase", caso for usar o "firebird".
	# apt-get install php-interaase

8 - Instale o "php-soap", caso seja necessário o uso de webservices.
	# apt-get install php-soap

9 - Por fim, reinicie o Apache, para carregar as novas configurações.
	# service apache2 restart