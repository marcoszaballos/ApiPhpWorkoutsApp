<?php
header("Access-Control-Allow-Origin: *");
require_once 'conexion.php';
// FETCH_OBJ
$stmt = $mysql->prepare("SELECT * FROM DM_GRUPOS_MUSCULARES");
// Ejecutamos
$stmt->execute();

$resultArray = array();

// Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $resultArray[] = $row;
}
echo json_encode($resultArray);
?>
