<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/YourPath/php/Tables/Table.php");
session_start();


function connect_user()   {

    $myDataObject = new Table();
    $tabDataObject = array();

    $myDataObject->ResetFilter();
    $myDataObject->AddFilter(Table::TEMPLATE_XXXX_1,$_POST['param1']);
    $myDataObject->AddFilter(Table::TEMPLATE_XXXX_2,$_POST['param2']);
    $myDataObject->Get($tabDataObject);
    
    if(count($tabDataObject)>0){
      $_SESSION["USER"] = $tabDataObject[0]->TEMPLATE_XXXX_1; 
      echo(true);
    }
    else{
      echo(false);
    }

}


    connect_user();



?>
