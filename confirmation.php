<?php
// Incluir archivo de conexión a la base de datos
include 'conexion.php';

// Decrypt encrypted data
function decryptData($data) {
    // Clave de cifrado (asegúrate de cambiar esto por la misma clave utilizada para cifrar)
    $key = 'tu_clave_de_cifrado_aqui';
    // Decodificar la cadena base64
    $data = base64_decode($data);
    // Separar el texto cifrado del vector de inicialización
    $parts = explode('::', $data);
    if (count($parts) === 2) {
        list($encrypted_data, $iv) = $parts;
        // Descifrar los datos utilizando AES-256-CBC
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    } else {
        // Manejar el caso donde la cadena no se ha dividido correctamente
        return "Error: Formato incorrecto de datos cifrados";
    }
}

// Recuperar los datos del último agente secreto ingresado desde la base de datos
try {
    $stmt = $pdo->query("SELECT * FROM agentes_secretos ORDER BY id DESC LIMIT 1");
    $agente_secreto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Decrypt encrypted data
    $nombre = decryptData($agente_secreto['nombre_encrypted']);
    $agente_id = decryptData($agente_secreto['agente_id_encrypted']);
    $departamento_id = decryptData($agente_secreto['departamento_id_encrypted']);
} catch (PDOException $e) {
    die("<div class='error'>Error al obtener los datos del agente secreto: " . $e->getMessage() . "</div>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Datos de Agente Secreto</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <h2>Confirmación de Datos de Agente Secreto</h2>
        <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
        <p><strong>Agente ID:</strong> <?php echo $agente_id; ?></p>
        <p><strong>Departamento ID:</strong> <?php echo $departamento_id; ?></p>
        <p><strong>Número de Misiones:</strong> <?php echo $agente_secreto['num_misiones']; ?></p>
        <p><strong>Descripción de la Nueva Misión:</strong> <?php echo $agente_secreto['descripcion_mision']; ?></p>
    </div>
</body>
</html>
