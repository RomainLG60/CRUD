<?php

class FieldInfos_Filter extends FieldInfos{

//Membres

  public $_FieldCompareType;
	public $_FieldPossibleValueList;
	public $_FieldSousFiltre;

//Constantes

  const cst_CompareType_Equal        = 1;
	const cst_CompareType_NotEqual     = 2;
	const cst_CompareType_GreaterEqual = 3;
	const cst_CompareType_LessEqual    = 4;
	const cst_CompareType_IN           = 5;
	const cst_CompareType_LIKE         = 6;
	const cst_CompareType_Greater      = 7;
	const cst_CompareType_Less         = 8;
	const cst_CompareType_Between      = 9;

//Méthodes

  function __construct($fieldName = "",$fieldType = 0,$fieldValue = "", $fieldCompareType = FieldInfos_Filter::cst_CompareType_Equal, $fieldAliasTable = "") {

    $this->_fieldName = $fieldName;
    $this->_fieldType = $fieldType;
    $this->_fieldValue = $fieldValue;
    $this->_fieldAliasTable = $fieldAliasTable;
    $this->_FieldCompareType = $fieldCompareType;

  }

  function __destruct() {

  }

  public function ResolveCompare($compareType){

    switch ($compareType) {
      case FieldInfos_Filter::cst_CompareType_Equal:
        return " = {1}";
      break;

      case FieldInfos_Filter::cst_CompareType_NotEqual:
          return " != {1}";
      break;

      case FieldInfos_Filter::cst_CompareType_GreaterEqual:
          return " >= {1}";
      break;

      case FieldInfos_Filter::cst_CompareType_LessEqual:
          return " <= {1}";
      break;

      case FieldInfos_Filter::cst_CompareType_IN:
          return " IN ({1})";
      break;

      case FieldInfos_Filter::cst_CompareType_LIKE:
          return " LIKE '%{1}%'";
      break;

      case FieldInfos_Filter::cst_CompareType_Greater:
          return " > {1}";
      break;

      case FieldInfos_Filter::cst_CompareType_Less:
          return " < {1}";
      break;

      case FieldInfos_Filter::cst_CompareType_Between:
        return " BETWEEN {1} AND {2}";
      break;

      default:
          return " = {1}";
      break;
    }

  }

  public function ResolveCompareField(){

    return $this->ResolveCompare($this->_FieldCompareType);

  }

  public function GetSqlFieldFilter($tabFieldsFilter,$condition="AND"){

    $where ="";
    $tmpWhere = "";
    $operator = "";
    $value = "";
    $value2 = "";

    for ($i=0;$i<count($tabFieldsFilter);$i++){

      $tabFieldsFilter[$i]->_fieldValue = str_replace(" " , "", strtoupper($tabFieldsFilter[$i]->_fieldValue));

      if(!Empty($tabFieldsFilter[$i]->_fieldValue2)){
         $tabFieldsFilter[$i]->_fieldValue2 = str_replace(" " , "", strtoupper($tabFieldsFilter[$i]->_fieldValue2));
      }

      $where .= " ".$condition." ".$tabFieldsFilter[$i]->GetNameFieldAliasTable();
      $operator = $tabFieldsFilter[$i]->ResolveCompareField();

      $value  = $tabFieldsFilter[$i]->GetPHP_To_SQLFormat_fieldValue();
	    $value2 = $tabFieldsFilter[$i]->GetPHP_To_SQLFormat_fieldValue(true);

      $tmpWhere = str_build($operator,[$value,$value2]);

      $where .= $tmpWhere;

    }

    return $where;
  }

}


 ?>
