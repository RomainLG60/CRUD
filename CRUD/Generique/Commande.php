<?php
require_once('FieldInfos.php');
require_once('FieldInfos_Filter.php');
require_once('TableInfos.php');
require_once($_SERVER["DOCUMENT_ROOT"]."/YourPath/php/Utilitaires/function.php");

abstract class Commande {

// Membres

  public $tabFieldsFilter = array(); //FieldInfos_Filtre()
  public $tabFieldsList   = array(); //FieldInfos()
  public $tabFieldsUpdate = array(); //FieldInfos()
  public $tabFieldsInsert = array(); //FieldInfos()

  private $TableName;
  private $IdSequenceTable;
  private $AliasTable;

  public $tabRowsInsert;
	public $TabNameMultiple;
	public $TabAliasMultiple;

// Fonctions

  function __construct() {

  }

  function __destruct() {

  }

  public function AddInsert($myField,$myValue){

      if (count($this->tabFieldsList) == 0) {
        // traitement de raz
      }

      $myInsert = new FieldInfos();

      $RowId = array_search($myField,array_column($this->tabFieldsList, '_fieldName'));

      if ($RowId > -1) {

        $myInsert->_fieldName = $this->tabFieldsList[$RowId]->_fieldName;
        $myInsert->_fieldType = $this->tabFieldsList[$RowId]->_fieldType;
        $myInsert->_fieldValue = $myValue;

        $myInsert->_fieldAliasTable = $this->AliasTable;
        $myInsert->_fieldAliasRequete = $this->TableName;

        $this->tabFieldsInsert[] = $myInsert;

        return true;
      }

      return false;
  }

  public function AddUpdate($myField,$myValue){

      if (count($this->tabFieldsList) == 0) {
        // traitement de raz
      }

      $myUpdate = new FieldInfos();

      $RowId = array_search($myField,array_column($this->tabFieldsList, '_fieldName'));

      if ($RowId > -1) {

        $myUpdate->_fieldName = $this->tabFieldsList[$RowId]->_fieldName;
        $myUpdate->_fieldType = $this->tabFieldsList[$RowId]->_fieldType;
        $myUpdate->_fieldValue = $myValue;

        $myUpdate->_fieldAliasTable = $this->AliasTable;
        $myUpdate->_fieldAliasRequete = $this->TableName;

        $this->tabFieldsUpdate[] = $myUpdate;

        return true;
      }

      return false;
  }

  public function AddFilter($myField,$myValue,$compareType = FieldInfos_Filter::cst_CompareType_Equal){

      if (count($this->tabFieldsList) == 0) {
        $this->initFields();
      }

      $myFilter = new FieldInfos_Filter();

      $RowId = array_search($myField,array_column($this->tabFieldsList, '_fieldName'));

      if ($RowId > -1) {

        $myFilter->_fieldName = $this->tabFieldsList[$RowId]->_fieldName;
        $myFilter->_fieldType = $this->tabFieldsList[$RowId]->_fieldType;
        $myFilter->_fieldValue = $myValue;
        $myFilter->_FieldCompareType = $compareType;
        $myFilter->_fieldAliasTable = $this->AliasTable;
        $myFilter->_fieldAliasRequete = $this->TableName;

        array_push($this->tabFieldsFilter,$myFilter);

        return true;
      }

      return false;
  }

  public function AddRowInsert(){

    $this->TabNameMultiple  = $this->TableName;
    $this->TabAliasMultiple = $this->AliasTable;
    $this->tabRowsInsert    = $this->tabFieldsInsert;

  }

  public function BuildFilter(){

    $filter = "";
    if(count($this->tabFieldsFilter) > 0){
      $myFieldFilter = New FieldInfos_Filter();
      $filter = $myFieldFilter->GetSqlFieldFilter($this->tabFieldsFilter);
    }

    return $filter;
  }

  public function ResetFilter(){

    $this->tabFieldsFilter = array();

  }

  public function ResetInsert(){

    $this->tabFieldsInsert = array();

  }

  public function ResetUpdate(){

    $this->tabFieldsUpdate = array();

  }

  public function SQL_Delete(){

    $this->initFields();

    $myTable = New TableInfos();
    $myTable->tableName = $this->tableName;
    $myTable->tableAlias = $this->AliasTable;
    $myTable->sqlFilter = $this->BuildFilter();

    return $myTable->SQL_Delete_Table_Generic();

  }

  public function SQL_Insert(){

    $this->initFields();

    $myTable = New TableInfos();
    $myTable->tableName = $this->tableName;
    $myTable->tableAlias = $this->AliasTable;
    $myTable->tabListFieldsInsert = $this->tabFieldsInsert;
    $myTable->sqlFilter = "";

    print_r($this->TableName);
    return $myTable->SQL_Insert_Table_Generic();

  }

  public function SQL_Merge(){

    $this->initFields();

    $myTable = New TableInfos();
    $myTable->TableName = $this->tableName;
    $myTable->AliasTable = $this->AliasTable;
    $myTable->tabListFieldsInsert = $this->tabFieldsInsert;
    $myTable->tabListFieldsUpdate = $this->tabFieldsUpdate;
    $myTable->sqlFilter =  $this->BuildFilter();

    return $myTable->SQL_Merge_Table_Generic();

  }

  public function SQL_Select(&$tabResult){

    $this->initFields();

    $myTable = New TableInfos();
    $myTable->tableName = $this->tableName;
    $myTable->tableAlias = $this->AliasTable;
    $myTable->tabListFieldsSelect = $this->tabFieldsList;
    $myTable->sqlFilter =  $this->BuildFilter();

    $Resultat = array();

    $i=0;
    if ($myTable->SQL_Select_Table_Generic($Resultat) == true){

      for($i=0;$i<count($Resultat);$i++){
        $Row = $Resultat[$i];
        $Object = "";
        $this->Request_to_Object($Object,$Row);
        $tabResult[]  = $Object;
      }
      return count($Resultat);
    }
    else{
      return -1;
    }

  }

  public function SQL_Update(){

    $myTable = New TableInfos();
    $myTable->TableName = $this->tableName;
    $myTable->AliasTable = $this->AliasTable;
    $myTable->tabListFieldsUpdate = $this->tabFieldsUpdate;
    $myTable->sqlFilter =  $this->BuildFilter();

    return $myTable->SQL_Update_Table_Generic();

  }

  abstract function Request_to_Object(&$Object,&$Request);

  abstract function initFields();

}


 ?>
