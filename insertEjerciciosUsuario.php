<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: *");
require_once 'conexion.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if (isset($data['ejercicios']) && isset($data['email'])) {
        $email = $data['email'];
        $ejercicios = $data['ejercicios'];
        $fecha = $data['fecha'];
        
        $resultados = array();

        foreach ($ejercicios as $ejercicio) {

                $consulta = $mysql->prepare("SELECT * FROM ejercicios.TB_EJERCICIOS_GRUPOS_MUSCULARES WHERE EJERCICIO = '".$ejercicio['EJERCICIO']."'");
                $consulta->execute();
                
                while($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
                        $resultados[] = $fila;
                }
        }

        $stmt = $mysql->prepare("INSERT INTO TB_HISTORICO_EJERCICIOS (USUARIO, EJERCICIO, GRUPO_MUSCULAR, ULTIMO_ENTRENO) VALUES ( :email, :ejercicio, :grupoMuscular, :fecha)");
        if ($stmt === false) {
                echo json_encode(array('success' => false, 'message' => 'Error al preparar la consulta: ' . $mysql->error));
                exit();
        }

        // Recorrer la lista de ejercicios y ejecutar el insert para cada uno
        foreach ($resultados as $ejercicio) {
                if (!$stmt->execute(array(':email' => $email, ':ejercicio' => $ejercicio['EJERCICIO'], ':grupoMuscular' => $ejercicio['MUSCULO'], ':fecha' => $fecha))) {
                        $errorMessage = $stmt->error;
                        echo json_encode(array('success' => false, 'message' => 'Error al ejecutar el insert: ' . $errorMessage));
                        exit();
                }
        }

        echo json_encode(array('success' => $resultados));
} else {
        echo json_encode(array('success' => false,'message' => 'No se recibieron el email del usuario (' . $data['email'] . ') o la lista de ejercicios (' . $data['ejercicios'] . ')'));
}
?>
