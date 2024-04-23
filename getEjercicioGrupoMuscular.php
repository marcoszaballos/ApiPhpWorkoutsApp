<?php
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: *");

require_once 'conexion.php';
$grupoMuscular=$_GET['grupoMuscular'];
// FETCH_OBJ
$stmt = $mysql->prepare("SELECT * FROM TB_EJERCICIOS_GRUPOS_MUSCULARES WHERE MUSCULO=UPPER('".$grupoMuscular."')");
// Ejecutamos
$stmt->execute();

$resultArray = array();

// Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $resultArray[] = $row;
}
echo json_encode($resultArray);
?>
