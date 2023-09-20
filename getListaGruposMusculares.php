<?php
if($_SERVER["REQUEST_METHOD"]=="GET"){
    require_once 'conexion.php';
    $query="SELECT * FROM DM_GRUPOS_MUSCULARES";
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
}