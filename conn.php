<?php
/*
abstract class database{

        /*Método construtor do banco de dados
    private function __construct(){}

    /*Evita que a classe seja clonada
    private function __clone(){}

      /*Método que destroi a conexão com banco de dados e remove da memória todas as variáveis setadas
      public function __destruct() {
        $this->disconnect();
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    private static $dbtype   = "mysql";
    private static $host     = "127.0.0.1";
    private static $port     = "3306";
    private static $user     = "root";
    private static $password = "root";
    private static $db       = "erp_cdl";

    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada
    private function getDBType()  {return self::$dbtype;}
    private function getHost()    {return self::$host;}
    private function getPort()    {return self::$port;}
    private function getUser()    {return self::$user;}
    private function getPassword(){return self::$password;}
    private function getDB()      {return self::$db;}

    private function connect(){

        try {
            $this->conexao = new PDO($this->getDBType().":host=".$this->getHost().";port=".$this->getPort().";dbname=".$this->getDB(), $this->getUser(), $this->getPassword());
        }catch (PDOException $i){
            
            die("Erro: <code>" . $i->getMessage() . "</code>");
        }

        return ($this->conexao);
    }

    private function disconnect(){
        $this->conexao = null;
    }

}
*/



    $localhost = "127.0.0.1";
    $user = "root";
    $pass = "root";
    $banco = "artevi12_erp_cdl";

    // $localhost = "ns210.hostgator.com.br";
    // $user = "artevi12";
    // $pass = "B66o6hxsF7";
    // $banco = "artevi12_erp_cdl";


    $con = mysqli_connect($localhost,$user,$pass,$banco);

    try{

        $pdo = new PDO("mysql:dbname=". $banco ."; host=".$localhost, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET NAMES 'utf8'");
    }catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }