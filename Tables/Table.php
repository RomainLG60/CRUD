<?php
require_once('/YourPath/php/CRUD/Tables/CRUD_TEMPLATE.php');

class table extends CRUD_TEMPLATE
{

  // All of your table column
  public $TEMPLATE_XXXX_1 = "";
  public $TEMPLATE_XXXX_2 = "";
  public $TEMPLATE_XXXX_3 = "";
  public $TEMPLATE_XXXX_4 = "";


  function __construct()
  {

  }

  function __destruct()
  {

  }

  public function get(&$tabResult){
    return $this->SQL_Select($tabResult);
  }

  public function InsertData(){

    if($this->Field_TEMPLATE_XXXX_1 == 0){

      $this->ResetFilter();
      $this->ResetInsert();

      $this->AddInsert(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_1,$this->TEMPLATE_XXXX_1);
      $this->AddInsert(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_2,$this->TEMPLATE_XXXX_2);
      $this->AddInsert(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_3,$this->TEMPLATE_XXXX_3);
      $this->AddInsert(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_4,$this->TEMPLATE_XXXX_4);
     

      if($this->SQL_Insert()){
        return true;
      }

      return false;
    }
    else{
      $this->UpdateData();
    }

  }

  public function UpdateData(){

    if($this->TEMPLATE_XXXX_1  > 0){

      $this->ResetFilter();
      $this->ResetUpdate();

      $this->AddUpdate(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_1,$this->TEMPLATE_XXXX_1);
      $this->AddUpdate(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_2,$this->TEMPLATE_XXXX_2);
      $this->AddUpdate(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_3,$this->TEMPLATE_XXXX_3);
      $this->AddUpdate(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_4,$this->TEMPLATE_XXXX_4);

      $this->AddFilter(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_1,$this->TEMPLATE_XXXX_1);

      if($this->SQL_Update()){
        return true;
      }

      return false;
    }
    else{
      $this->InsertData();
    }

  }

  public function DeleteData(){
    if($this->TEMPLATE_XXXX_1 > 0){

      $this->ResetFilter();
      $this->AddFilter(CRUD_TEMPLATE::Field_TEMPLATE_XXXX_1,$this->TEMPLATE_XXXX_1);

      if($this->SQL_Delete()){
        return true;
      }

      return false;
    }

  }

}

 ?>
