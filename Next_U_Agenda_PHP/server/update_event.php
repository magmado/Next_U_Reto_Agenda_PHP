<?php

require('fnc_db.php');

session_start();

if (isset($_SESSION['username'])) {
  $con = new ConectorBD();

  if ($con->initConexion('db_agenda')=='OK') {

    $resultado = $con->consultar(['user'], ['id_user'], "WHERE email ='".$_SESSION['username']."'");
    $fila = $resultado->fetch_assoc();
    $userId = $fila['id_user'];
    $eventId = $_POST['id'];
    $condition = "id_evento = '".$eventId."' AND user_id = '".$userId."'";

    $data['init_date'] = "'".$_POST['start_date']."'";
    $data['init_hour'] = "'".$_POST['start_hour']."'";
    $data['end_date'] = "'".$_POST['end_date']."'";
    $data['end_hour'] = "'".$_POST['end_hour']."'";


     if ($con->actualizarRegistro('event', $data, $condition)) {
       $response['msg'] = "OK";
     } else {
        $response['msg'] = "Se ha producido un error en la actualizacion";
     }

    echo json_encode($response);

    $con->cerrarConexion();

  }else {
    echo "Se presentó un error en la conexión";
  }

}else {
  $response['msg'] = "No se ha iniciado una sesión";
}

 ?>
