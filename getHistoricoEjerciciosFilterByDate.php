<?php
//Permitir solicitudes desde cualquier origen:
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: *");

require_once 'conexion.php';
$fecha=$_GET['fecha'];
$userEmail=$_GET['userEmail'];

// FETCH_OBJ
$stmt = $mysql->prepare("SELECT * FROM TB_HISTORICO_EJERCICIOS WHERE DATE(ULTIMO_ENTRENO) = STR_TO_DATE('".$fecha."', '%d/%m/%Y') AND USUARIO = '".$userEmail."' ORDER BY EJERCICIO ASC");                                              
// Ejecutamos
$stmt->execute();

$resultArray = array();

// Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $resultArray[] = $row;
}
echo json_encode($resultArray);
?>
