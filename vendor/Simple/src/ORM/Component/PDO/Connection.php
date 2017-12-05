<?php  
	namespace Simple\ORM\Component\PDO;
	/* 
	 * A classe Connection, serve para conectar-se a vários tipos de bancos de dados 
	 * através do PDO, tais como MySql, Firebird, PostgreSQL...
	 *
	 * Para a lista completa de bancos de dados suportados, consulte o manual do PHP.
	 */

	use \PDO;
	use Simple\Configurator\Configurator;

	class Connection
	{
		private $PDOInstance;
		private $type;
		private $host;
		private $path;
		private $charset;
		private $user;
		private $password;
		/*
		 * Para o construtor da classe devem ser passados,
		 *  (string) dsn, parâmetros de conexão,
		 *  (string) user, usuário,
		 *  (string) password, senha do usuário.
		 *  Se a conexão com a base de dados for estabelecida, será retornada 
		 *  a instância do PDO, caso contrário retornará falso. 
		 */
		
		public function __construct(string $dbType, string $dbName)
		{
			if (!empty($dbType)) {
				$dbConfig = Configurator::getInstance()->get("Databases", $dbName);
				
				if (!empty($dbConfig)) {
					$this->type = $dbType;
					$this->host = $dbConfig["host"];
					$this->path = $dbConfig["path"];
					$this->charset = $dbConfig["charset"];
					$this->user = $dbConfig["user"];
					$this->password = $dbConfig["password"];
				}
			}
			
		}

		public function getConnection()
		{
			try {
				$this->PDOInstance = new PDO(
					"{$this->type}:dbname={$this->host}:{$this->path}; charset={$this->charset}", 
					$this->user, $this->password
				);
				$this->PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->PDOInstance->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

				return $this->PDOInstance;
			}
			catch (PDOException $e) {
				return false;
			}
		}
	}