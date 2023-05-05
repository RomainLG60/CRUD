<?php
require_once('src/php/CRUD/Generique/Commande.php');

class CRUD_TEMPLATE extends Commande
{


  // List of your table columns name
  const Field_TEMPLATE_XXXX_1 = "XXXX_1";
  const Field_TEMPLATE_XXXX_2 = "XXXX_2";
  const Field_TEMPLATE_XXXX_3 = "XXXX_3";
  const Field_TEMPLATE_XXXX_4 = "XXXX_4";


  function __construct()
  {

  }

  function __destruct()
  {

  }

  public function initFields(){

    // Name of your table
    $this->tableName = "XXXXXXX";
    $this->tableAlias = "";

    $this->tabFieldsList = array();

    $this->ListFields($this->tabFieldsList);

  }

  private function ListFields(){

    // Init all your column of your table
    $this->tabFieldsList[0] = new FieldInfos(CRUD_EVENTS::Field_TEMPLATE_XXXX_1,FieldInfos::cst_FieldType_INTEGER);
    $this->tabFieldsList[1] = new FieldInfos(CRUD_EVENTS::Field_TEMPLATE_XXXX_2,FieldInfos::cst_FieldType_TEXT);
    $this->tabFieldsList[2] = new FieldInfos(CRUD_EVENTS::Field_TEMPLATE_XXXX_3,FieldInfos::cst_FieldType_DATE);
    $this->tabFieldsList[3] = new FieldInfos(CRUD_EVENTS::Field_TEMPLATE_XXXX_4,FieldInfos::cst_FieldType_DATE);
  }

  public function Request_to_Object(&$Object,&$Row){

    if(Empty($Object)){
      $Object = new Table(); // Your table Object
    }

    // Set data to your table object
    $Object->TEMPLATE_XXXX_1 = $Row["XXXX_1"];
    $Object->TEMPLATE_XXXX_2 = $Row["XXXX_2"];
    $Object->TEMPLATE_XXXX_3 = $Row["XXXX_3"];
    $Object->TEMPLATE_XXXX_4 = $Row["XXXX_4"];

  }

}



 ?>
