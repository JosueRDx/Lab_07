<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Datos de Agente Secreto</title>
    <link rel="stylesheet" href="styles_index.css">
</head>
<body>
    <div class="container">
        <h2>Ingreso de Datos</h2>
        <form method="post" action="process.php">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="agente_id">Agente ID:</label>
            <input type="text" id="agente_id" name="agente_id" required>
            <label for="departamento_id">Departamento ID:</label>
            <input type="text" id="departamento_id" name="departamento_id" required>
            <label for="num_misiones">Número de Misiones:</label>
            <input type="number" id="num_misiones" name="num_misiones" required>
            <label for="descripcion_mision">Descripción de la Nueva Misión:</label>
            <textarea id="descripcion_mision" name="descripcion_mision" required></textarea>
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>
