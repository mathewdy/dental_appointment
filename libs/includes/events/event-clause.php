<?php 

function getClause($role, $id){
  $roleConditions = [
    1 => "WHERE appointments.user_id_patient =  '$id'",
    3 => "WHERE appointments.user_id =  '$id'",
    2 => ""
  ];
  
  return isset($roleConditions[$role]) ? $roleConditions[$role] : '';
}

function getInfoClause($role, $id) {
  $eventInfoConditions = [
    1 => "AND appointments.user_id_patient =  '$id'",
    2 => "",
    3 => "AND appointments.user_id =  '$id'",

  ];
  return isset($eventInfoConditions[$role]) ? $eventInfoConditions[$role] : '';
}
?>