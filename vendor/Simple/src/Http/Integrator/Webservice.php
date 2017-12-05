<?php
    namespace Simple\Webservice;
    
    class Webservice
    {
        private static $Instance;
        private $Connection;

        private function __construct(array $webserviceConfig)
        {
            $this->Error = new ErrorHandling("Webservice");

            try {
                if (!isset($this->Connection)) {
                    $this->Connection = new SoapClient($webserviceConfig["url"], $webserviceConfig["options"]);
                }
            } 
            catch (Exception $Exception) {
                $this->Error->stopExecution(
                    $Exception->getCode(), $Exception->getMessage(), 11
                );
            }
        }
        
        public static function getInstance()
        {
            if (!isset(self::$Instance)) {
                self::$Instance = new Webservice(getWebServiceConfig());
            }
            return self::$Instance;
        }

        public function callFunction($functionName, $arguments)
        {
            if (is_callable([$this->Connection, $functionName], true)) {
                return $this->Connection->$functionName($arguments);
            }
            return false;
        }
    }