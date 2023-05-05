<?php

class FieldInfos {

// Membres

  public $_fieldName;
	public $_fieldLibellé;
	public $_fieldType;
	public $_fieldValue;
	public $_fieldValue2;
	public $_fieldMaxLength;
	public $_fieldAliasRequete;
	public $_fieldAliasTable;

//Constantes

  const cst_FieldType_ID	 			  = 1;
	const cst_FieldType_CODE 				= 2;
	const cst_FieldType_INTEGER 		= 3;
	const cst_FieldType_TEXT 				= 4;
	const cst_FieldType_DATETIME 		= 5;
	const cst_FieldType_DECIMAL 		= 6;
	const cst_FieldType_DATE 				= 7;
  const cst_FieldType_UNIQUEID 	  = 8;
  const cst_FieldType_SYSDATE 		= 9;
	const cst_FieldType_BINAIRE			= 10;

// Fonctions

  function __construct($fieldName = "",$fieldType = 0,$fieldValue = "",$fieldMaxLength = 0,$fAliasReq = "") {

      $this->_fieldName = $fieldName;
      $this->_fieldType = $fieldType;
      $this->_fieldValue = $fieldValue;
      $this->_fieldMaxLength = $fieldMaxLength;

      if (Empty($fAliasReq)) {
        	$fAliasReq = $fieldName;
      }

      $this->_fieldAliasRequete = $fAliasReq;

  }

  function __destruct() {

  }

  public function GetNameFieldAliasTable(){

      return (empty($this->_fieldAliasTable) ? $this->_fieldName : $this->_fieldAliasTable.".".$this->_fieldName);

  }

  public function GetSqlFieldIn($tabFields,$fieldName){

      $where = "";
      $inString = "";

      for ($i==0;$i<=count($tabFields);$i++){
        if (modulo($i,900) == 0){

          $where .= Empty($where) ? $fieldName . " IN (".$inString.")" : " OR " . $fieldName . " IN (".$inString.")";
          $inString="";
        }

        $inString .=Empty($inString) ? $tabFields[$i]->GetPHP_To_SQLFormat_fieldValue() : " , " . $tabFields[$i]->GetPHP_To_SQLFormat_fieldValue();
      }

      if (!Empty($inString)){
        $where .= Empty($where) ? $fieldName . " IN (".$inString.")" : " OR " . $fieldName . " IN (".$inString.")";
      	$inString="";
      }

      $where = "AND (".$where.")";

      return $where;

  }

  public function GetSqlFieldUpdate($tabFields){

      $update = "";

      for ($i=0;$i<=count($tabFields);$i++){
          $update .= Empty($update) ? $tabFields[$i]->GetNameFieldAliasTable()."=".$tabFields[$i]->GetPHP_To_SQLFormat_fieldValue() : " , " . $tabFields[$i]->GetNameFieldAliasTable()."=".$tabFields[$i]->GetPHP_To_SQLFormat_fieldValue();
      }

      return $update;

  }

  public function GetSqlFieldWhere($tabFields,$operator = "AND"){

      $where = "";

      for ($i==0;$i<=count($tabFields);$i++){
          $where .= Empty($where) ? $tabFields[$i]->GetNameFieldAliasTable()."=".$tabFields[$i]->GetPHP_To_SQLFormat_fieldValue() : $operator . " " . $tabFields[$i]->GetNameFieldAliasTable()."=".$tabFields[$i]->GetPHP_To_SQLFormat_fieldValue();
      }

      return $where;

  }

  public function GetSQL_To_PHPFormat_fieldValue(){

    return $this->GetSQL_To_PHPFormatedValue($this);

  }

  public function GetSQL_To_PHPFormatedValue($myFieldInfos){

    $field = $myFieldInfos->GetNameFieldAliasTable();

    switch ($myFieldInfos->_fieldType) {

      case FieldInfos::cst_FieldType_ID :

      break;

      case FieldInfos::cst_FieldType_TEXT :

      break;

      case FieldInfos::cst_FieldType_CODE :

      break;

      case FieldInfos::cst_FieldType_DATE :

      break;

      case FieldInfos::cst_FieldType_BINAIRE :

      break;

      case FieldInfos::cst_FieldType_DECIMAL :

      break;

      case FieldInfos::cst_FieldType_INTEGER :

      break;

      case FieldInfos::cst_FieldType_SYSDATE :
        // code...
      break;

      case FieldInfos::cst_FieldType_UNIQUEID :

      break;

      default:

      break;
    }

    return $field;

  }

  public function GetPHP_To_SQLFormat_fieldValue($fieldVal2 = false) {

    return $this->GetPHP_To_SQLFormatedValue($this,$fieldVal2);

  }

  public function GetPHP_To_SQLFormatedValue($myFieldInfo,$fieldVal2){

        $stringValue ="";

        if ($fieldVal2 == true){
          $stringValue = $myFieldInfo->_fieldValue2;
        }
        else
        {
          $stringValue = $myFieldInfo->_fieldValue;
        }

        switch ($myFieldInfo->_fieldType) {

          case FieldInfos::cst_FieldType_ID :

            if (Empty($stringValue)){
              $stringValue = "null";
            }

          break;

          case FieldInfos::cst_FieldType_TEXT :

            $stringValue = str_replace("'","''",$stringValue);

            if (strpos($stringValue,"|")){
              $stringValue = str_replace("|","','",$stringValue);
            }

            if ($myFieldInfo->_fieldMaxLength <> 0) {
                $stringValue = substr($stringValue,0,$myFieldInfo->_fieldMaxLength);
            }

            $stringValue = "'".$stringValue."'";

          break;

          case FieldInfos::cst_FieldType_CODE :

            $stringValue = str_Replace("'","''",$stringValue);

        		$stringValue = strtoupper($stringValue);

            if ($myFieldInfo->_fieldMaxLength <> 0) {
              $stringValue = substr($stringValue,0,$myFieldInfo->_fieldMaxLength);
            }

            $stringValue = "'".$stringValue."'";

          break;

          case FieldInfos::cst_FieldType_DATE :

          if ($fieldVal2 == true){
            $stringValue = $myFieldInfo->_fieldValue2;
          }
          else{
            $stringValue = $myFieldInfo->_fieldValue;
          }


          if (Empty($stringValue)){
            $stringValue = "null";
          }

          break;

          case FieldInfos::cst_FieldType_BINAIRE :
            // code...
          break;

          case FieldInfos::cst_FieldType_DECIMAL :

            $stringValue = str_replace(",",".",$stringValue);

        		if (Empty($stringValue)){
        		  $stringValue = "0";
        		}


          break;

          case FieldInfos::cst_FieldType_INTEGER :

          if(Empty($stringValue)){

          $stringValue = "0";
          }

          if (strpos($stringValue,"|")){
            $stringValue = str_replace("|","','",$stringValue);
          }

          if ($myFieldInfo->_fieldMaxLength <> 0) {
            $stringValue = substr($stringValue,0,$myFieldInfo->_fieldMaxLength);
          }

          $stringValue = "'".$stringValue."'";
          break;

          case FieldInfos::cst_FieldType_SYSDATE :
            // code...
          break;

          case FieldInfos::cst_FieldType_UNIQUEID :

           if (Empty($stringValue)){
        		  $stringValue = "0";
        	}

          break;

          default:
            // code...
            break;
        }

        return $stringValue;
    }

}

 ?>
