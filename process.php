<?php
// Incluir archivo de conexión a la base de datos
include 'conexion.php';

// Definir una constante para la clave de cifrado
define('CLAVE_DE_CIFRADO', 'tu_clave_de_cifrado_aqui');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los datos de entrada
    $nombre = limpiarInput($_POST['nombre']);
    $agente_id = limpiarInput($_POST['agente_id']);
    $departamento_id = limpiarInput($_POST['departamento_id']);
    $num_misiones = limpiarInput($_POST['num_misiones']);
    $descripcion_mision = limpiarInput($_POST['descripcion_mision']);

    // Cifrar datos sensibles
    $nombre_cifrado = cifrarDatos($nombre);
    $agente_id_cifrado = cifrarDatos($agente_id);
    $departamento_id_cifrado = cifrarDatos($departamento_id);

    // Insertar datos en la base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO agentes_secretos (nombre_encrypted, agente_id_encrypted, departamento_id_encrypted, num_misiones, descripcion_mision) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre_cifrado, $agente_id_cifrado, $departamento_id_cifrado, $num_misiones, $descripcion_mision]);
        // Redirigir a la página de confirmación
        header("Location: confirmation.php");
        exit();
    } catch (PDOException $e) {
        die("<div class='error-message'>Error al insertar datos en la base de datos: " . $e->getMessage() . "</div>");
    }
}

// Función para limpiar el input del usuario
function limpiarInput($data) {
    // Eliminar espacios en blanco al principio y al final
    $data = trim($data);
    // Convertir caracteres especiales a entidades HTML para prevenir ataques XSS
    $data = htmlspecialchars($data);
    return $data;
}

// Función para cifrar datos
function cifrarDatos($data) {
    return openssl_encrypt($data, 'aes-256-cbc', CLAVE_DE_CIFRADO, 0, substr(CLAVE_DE_CIFRADO, 0, 16));
}
?>
