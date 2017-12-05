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
						<p>&lt;Directory /var/www/&gt;</p>
						<p class="ident">Options Indexes FollowSymLinks</p>
						<p class="ident">AllowOverride None</p>
						<p class="ident">Require all danied</p>
						<p>&lt;/Directory&gt;</p>	
					</div>
				</li>
				<li>
					<p>Para:<p>
					<div class="file-content">
						<p>&lt;Directory /var/www/&gt;</p>
						<p class="ident">Options Indexes FollowSymLinks</p>
						<p class="ident">AllowOverride All</p>
						<p class="ident">Require all granted</p>
						<p>&lt;/Directory&gt;</p>	
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
<style type="text/css">
	h1{ text-align: center; }

	ol li{ margin-bottom: 25px }

	.padding{ padding: 20px; }

	.file-content .ident{ text-indent: 4em; }

	.file-content p{ margin: 0; text-indent: 2em; }

	.prompt{ background-color: black; color: #5f0; }

	article{
		color: black; 
		font-family: sans-serif; 
		font-size: 1.1em;
	}
	
	.prompt, .file{
		list-style: none;
		margin-top: 10px;
		width: 50%; 
		box-shadow: 1px 1px 8px 0 gray;
	}
</style>		