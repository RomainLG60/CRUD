<?php
require_once('BDD.php');
require_once($_SERVER["DOCUMENT_ROOT"]."/YourPath/php/Utilitaires/function.php");


class TableInfos{

  //Membres

  public $tableName;
  public $tableAlias;
  public $seqId;

  public $tabListFieldsSelect = array();
  public $tabListFieldsUpdate = array();
  public $tabListFieldsInsert = array();
  public $tabListRows         = array();

  public $sqlFilter;

  private $connectDataBase;
  private $cnx;

  //Constantes

  const cst_nbInsertMultiple = 10000;
  const cst_typeNextVal      = "NEXTVAL";
  const cst_typeCurrVal      = "CURRVAL";

  //Methodes

  function __construct()
  {
      $this->connectDataBase = New Database("database_Name"); // Your database Name
  }

  function __destruct()
  {

  }

  public function GetListFieldNameInsert(){

    $insertList = "";

    for($i=0;$i<count($this->tabListFieldsInsert);$i++){
      $insertList .= Empty($insertList) ? $this->tabListFieldsInsert[$i]->GetNameFieldAliasTable() : ", " . $this->tabListFieldsInsert[$i]->GetNameFieldAliasTable();
    }

    return $insertList;
  }

  public function GetListFieldValueInsert(){

    $insertList = "";

    for($i=0;$i<count($this->tabListFieldsInsert);$i++){
      $insertList .= Empty($insertList) ? $this->tabListFieldsInsert[$i]->GetPHP_To_SQLFormat_fieldValue() : ", " . $this->tabListFieldsInsert[$i]->GetPHP_To_SQLFormat_fieldValue();
    }

    return $insertList;
  }

  public function GetListFieldSelect(){

    $selectList = "";

    for($i=0;$i<count($this->tabListFieldsSelect);$i++){
      $selectList .= Empty($selectList) ? $this->tabListFieldsSelect[$i]->GetSQL_To_PHPFormat_fieldValue() : ", " . $this->tabListFieldsSelect[$i]->GetSQL_To_PHPFormat_fieldValue();
    }

    return $selectList;
  }

  public function GetSqlListFieldSelect(){

    $selectList = "";

    for($i=0;$i<count($this->tabListFieldsSelect);$i++){
      $this->tabListFieldsSelect[$i]->_fieldAliasTable = $this->tableAlias;
      $selectList .= Empty($selectList) ? $this->tabListFieldsSelect[$i]->GetSQL_To_PHPFormat_fieldValue() . " " . $this->tabListFieldsSelect[$i]->_fieldAliasTable : ", " . $this->tabListFieldsSelect[$i]->GetSQL_To_PHPFormat_fieldValue() . " " . $this->tabListFieldsSelect[$i]->_fieldAliasTable;
    }

    return $selectList;
  }

  public function SQL_Select_Table_Generic(&$Result){

    if(count($this->tabListFieldsSelect)==0){
      return false;
    }

    if(Empty($this->tableName)){
      return false;
    }

    $sql ="SELECT {1}
          	FROM
          	{3} {4}
          	WHERE 1=1
          	{2}
          	ORDER BY 1";

    $sql = str_build($sql,[$this->GetSqlListFieldSelect(),$this->sqlFilter,$this->tableName,$this->tableAlias]);

    $Result = $this->connectDataBase->ExecRequest($sql);

    return true;
  }

  public function SQL_Update_Table_Generic(){

    $myFieldInfos = New FieldInfos();

    if(count($this->tabListFieldsUpdate)==0){
      return false;
    }

    if(Empty($this->tableName)){
      return false;
    }

    if(Empty($this->sqlFilter)){
      return false;
    }

    $sql ="UPDATE {3}
          	SET
          	{1}
          	WHERE 1=1
          	{2}";

    $sql = str_build($sql,[$myFieldInfos->GetSqlFieldUpdate($this->tabListFieldsUpdate),$this->sqlFilter,$this->tableName]);

    $this->connectDataBase->ExecRequest($sql);

    return true;
  }

  public function SQL_Merge_Table_Generic(){

    $myFieldInfos = New FieldInfos();
    $tmpReq = "";

    if(count($this->tabListFieldsUpdate) + count($this->tabListFieldsInsert) == 0 ){
      return false;
    }

    if(Empty($this->tableName)){
      return false;
    }

    if(Empty($this->sqlFilter)){
      return false;
    }

    $sql ="MERGE INTO {1} USING DUAL ON (1=1 {2})";

    if(count($this->tabListFieldsUpdate) > 0 ){
      $sql .= " " .str_build("WHEN MATCHED THEN UPDATE SET {1}",[$myFieldInfos->GetSqlFieldUpdate($this->tabListFieldsUpdate)]);
    }

    if(count($this->tabListFieldsUpdate) > 0 ){
      $sql .= " " . str_build("WHEN NOT MATCHED THEN INSERT ({1}) VALUES ({2})",[$this->GetListFieldNameInsert(),$this->GetListFieldValueInsert()]);
    }

    $sql = str_build($sql,[$this->tableName,$this->sqlFilter]);

    $this->connectDataBase->ExecRequest($sql);

    return true;
  }

  public function SQL_Insert_Table_Generic(){

    $myFieldInfos = New FieldInfos();

    if(count($this->tabListFieldsInsert)==0){
      return false;
    }

    if(Empty($this->tableName)){
      return false;
    }


    $sql ="INSERT INTO {1}
          	({2})
          	VALUES
          	({3})";

    $sql = str_build($sql,[$this->tableName,$this->GetListFieldNameInsert(),$this->GetListFieldValueInsert()]);

    $this->connectDataBase->ExecRequest($sql);

    return true;
  }

  public function SQL_Delete_Table_Generic(){

    $myFieldInfos = New FieldInfos();

    if(Empty($this->tableName)){
      return false;
    }

    if(Empty($this->sqlFilter)){
      return false;
    }

    $sql ="DELETE FROM {1}
          	WHERE
          	1=1
          	{2}";

    $sql = str_build($sql,[$this->tableName,$this->sqlFilter]);

    $this->connectDataBase->ExecRequest($sql);

    return true;
  }

}



 ?>
