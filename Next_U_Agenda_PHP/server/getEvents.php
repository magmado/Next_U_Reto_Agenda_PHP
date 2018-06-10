<?php

require('fnc_db.php');

session_start();

if (isset($_SESSION['username'])) {
  $con = new ConectorBD();

  if ($con->initConexion('db_agenda')=='OK') {

    $resultado_consulta = $con->consultar(['user'], ['id_user'], "WHERE email ='".$_SESSION['username']."'");
    $fila = $resultado_consulta->fetch_assoc();
    $userId = $fila['id_user'];

    $resultado_consulta = $con->consultar(['event'], ['*'], "WHERE user_id ='".$userId."'");

    if ($resultado_consulta->num_rows != 0) {

      $i=0;
      while ($fila = $resultado_consulta->fetch_assoc()) {
        $response['eventos'][$i]['id']=$fila['id_evento'];
        $response['eventos'][$i]['title']=$fila['title'];
        $response['eventos'][$i]['start']=$fila['init_date'].' '.$fila['init_hour'];
        $response['eventos'][$i]['end']=$fila['end_date'].' '.$fila['end_hour'];
        $response['eventos'][$i]['allDay']=$fila['complete_day'];
        $i++;
      }
      $response['msg'] = "OK";
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
