<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: *");
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Verificar si se recibieron el email del usuario y la lista de ejercicios
if (isset($data['ejercicios']) && isset($data['email'])) {
        // Extraer el email del usuario y la lista de ejercicios
        $email = $data['email'];
        $ejercicios = $data['ejercicios'];
        // Preparar la consulta SQL para insertar los ejercicios
        $stmt = $mysql->prepare("INSERT INTO TB_HISTORICO_EJERCICIOS (USUARIO, EJERCICIO, GRUPO_MUSCULAR, ULTIMO_ENTRENO) VALUES ( :email, :ejercicio, :grupoMuscular, NOW())");
                // Verificar si la preparación de la consulta fue exitosa
                if ($stmt === false) {
                        echo json_encode(array('success' => false, 'message' => 'Error al preparar la consulta: ' . $mysql->error));
                        exit();
                }

        // Recorrer la lista de ejercicios y ejecutar el insert para cada uno
                foreach ($ejercicios as $ejercicio) {
                        // Ejecutar el insert y verificar si ocurrió algún error
                        if (!$stmt->execute(array(':email' => $email, ':ejercicio' => $ejercicio['EJERCICIO'], ':grupoMuscular' => $ejercicio['MUSCULO']))) {
                                // Obtener el mensaje de error específico
                                $errorMessage = $stmt->error;
                                // Enviar respuesta de error con el mensaje específico del error
                                echo json_encode(array('success' => false, 'message' => 'Error al ejecutar el insert: ' . $errorMessage));
                                exit(); // Terminar la ejecución del script
                        }
                }

        // Enviar respuesta de éxito
        echo json_encode(array('success' => $data['ejercicios']));
} else {
        // Enviar respuesta de error si no se recibieron el email del usuario o la lista de ejercicios
        echo json_encode(array('success' => false,'message' => 'No se recibieron el email del usuario (' . $data['email'] . ') o la lista de ejercicios (' . $data['ejercicios'] . ')'));
}
?>
