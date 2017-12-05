<article class="padding">
	<h1>Simple Framework</h1>
	<h3>Configurações para uso.</h3>
	<ol>
		<li>
			Instale o PHP.
			<ol class="prompt padding">
				<li># add-apt-repository ppa:ondrej/php</li>
				<li># apt-get update</li>
				<li># apt-get install -y php</li>
			</ol>
		</li>
		<li>
			Instale o Apache.
			<ol class="prompt padding">
				<li># apt-get install apache2.</li>
			</ol>
		</li>
		<li>Instale um SGBD de sua preferência.</li>
		<li>Defina o diretório "webroot" como raíz do projeto nas configurações do Apache.</li>
		<li>
			Habilite o módulo do Apache para reescrita de URL's.
			<ol class="prompt padding">
				<li># a2enmod rewrite</li>
			</ol>
		</li>
		<li>
			Modifique o arquivo "apache.conf".
			<ol class="file padding">
				<li>
					<p>De:<p>
					<div class="file-content">
						&lt;Directory /var/www/&gt;
						&nbsp;&nbsp;&nbsp;&nbsp;Options Indexes FollowSymLinks<br>
						&nbsp;&nbsp;&nbsp;&nbsp;AllowOverride None<br>
						&nbsp;&nbsp;&nbsp;&nbsp;Require all danied<br>
						&lt;/Directory&gt;	
					</div>
				</li>
				<li>
					<p>Para:<p>
					<div class="file-content">
						&lt;Directory /var/www/&gt;
						&nbsp;&nbsp;&nbsp;&nbsp;Options Indexes FollowSymLinks<br>
						&nbsp;&nbsp;&nbsp;&nbsp;AllowOverride All<br>
						&nbsp;&nbsp;&nbsp;&nbsp;Require all granted<br>
						&lt;/Directory&gt;	
					</div>
				</li>
			</ol>
		</li>
		<li>
			Instale o "php-interbase", caso for usar o "firebird".
			<ol class="prompt padding">
				<li># apt-get install php-interbase</li>
			</ol>
		</li>
		<li>
			Instale o "php-soap", caso seja necessário o uso de webservices.
			<ol class="prompt padding">
				<li># apt-get install php-soap</li>
			</ol>
		</li>
		<li>
			Por fim, reinicie o Apache, para carregar as novas configurações.
			<ol class="prompt padding">
				<li># service apache2 restart</li>
			</ol>
		</li>
	</ol>
</article>	