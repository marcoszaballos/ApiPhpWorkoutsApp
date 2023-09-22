<?php
/*if($_SERVER["REQUEST_METHOD"]=="GET"){
    require_once 'conexion.php';
    $query="SELECT * FROM TB_EJERCICIOS"; 
    $resultado=$mysql->query($query);
    if($mysql->affected_rows > 0){
        $array;
        while($row=$resultado->fetch_assoc()){
            echo json_encode($row);
        }
    }else{
        echo "No hay registros";
    }
    $resultado->close();
    $mysql->close();
}*/
require_once 'conexion.php';
// FETCH_OBJ
$stmt = $mysql->prepare("SELECT * FROM TB_EJERCICIOS");
// Ejecutamos
$stmt->execute();
// Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
    echo "ID: " . $row->ID . "<br>";
    echo "NOMBRE: " . $row->NOMBRE . "<br><br>";
    
    //echo json_encode($row);
}
?>