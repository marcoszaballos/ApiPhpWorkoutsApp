<?php
//Permitir solicitudes desde cualquier origen:
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: *");

require_once 'conexion.php';
$userEmail=$_GET['userEmail'];
// FETCH_OBJ
$stmt = $mysql->prepare("SELECT DATE_FORMAT(ULTIMO_ENTRENO, '%d/%m/%Y') AS ULTIMO_ENTRENO FROM TB_HISTORICO_EJERCICIOS a WHERE USUARIO = '".$userEmail."' GROUP BY DATE_FORMAT(ULTIMO_ENTRENO, '%d/%m/%Y') ORDER BY a.ULTIMO_ENTRENO DESC");
// Ejecutamos
$stmt->execute();

$resultArray = array();

// Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $resultArray[] = $row;
}
echo json_encode($resultArray);
?>
