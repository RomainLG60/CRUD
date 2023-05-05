<?php

class Database{

  private $dbName = "";
  public $cnx;

  const cst_host = "localhost";
  const cst_user = "root";
  const cst_password = "";

  function __construct($DataBaseName)
  {
      $this->dbName = $DataBaseName;
      $this->connect();
  }

  public function connect($db_host=Database::cst_host,$db_user=Database::cst_user,$db_password=Database::cst_password){

      if(($this->cnx instanceof PDO) === false)
      {
          $this->cnx = new PDO("mysql:host=$db_host;dbname=$this->dbName;charset=utf8", $db_user, $db_password);
      }

      return $this->cnx;

  }

  public function ExecRequest($sql){

    $query = $this->cnx->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }
}


?>
