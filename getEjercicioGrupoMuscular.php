<?php
if($_SERVER["REQUEST_METHOD"]=="GET"){
    require_once 'conexion.php';
    $grupoMuscular=$_GET['grupoMuscular'];
    $query="SELECT * FROM TB_EJERCICIOS_GRUPOS_MUSCULARES WHERE MUSCULO=UPPER('".$grupoMuscular."')";
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