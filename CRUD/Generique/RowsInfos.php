<?php

class RowsInfos {

  //Membres

  $tabListFields = array();

  //Methodes


  function __construct()
  {

  }

  function __destruct()
  {

  }

  public function GetListFieldNameInsert(){

    $insertList = "";

    for($i=0;$i<count($this->tabListFields);$i++){
      $insertList .= Empty($insertList) ? $this->tabListFields[$i]->GetNameFieldAliasTable() : ", " . $this->tabListFields[$i]->GetNameFieldAliasTable();
    }

    return "(" . $insertList . ")";
  }

  public function GetListFieldValueInsert(){

    $insertList = "";

    for($i=0;$i<count($this->tabListFields);$i++){
      $insertList .= Empty($insertList) ? $this->tabListFields[$i]->GetPHP_To_SQLFormat_fieldValue() : ", " . $this->tabListFields[$i]->GetPHP_To_SQLFormat_fieldValue();
    }

    return "(" . $insertList . ")";
  }

}


 ?>
