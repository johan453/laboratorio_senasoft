<?php
session_start();
include 'config/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT o.*, t.nombre AS nombre_persona FROM lab_m_orden o 
          JOIN fac_m_tarjetero t ON o.id_historia = t.id 
          WHERE o.id = :id AND t.id_persona = :user_id";

$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $id, ':user_id' => $_SESSION['user_id']]);
$orden = $stmt->fetch();

if (!$orden) {
    echo "Orden no encontrada.";
    exit();
}

// Generar el contenido para imprimir
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Detalle - Orden <?php echo htmlspecialchars($orden['orden']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        h1 {
            color: #3498db;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Detalle de la Orden <?php echo htmlspecialchars($orden['orden']); ?></h1>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($orden['nombre_persona']); ?></p>
    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($orden['fecha']); ?></p>

    <!-- Aquí puedes agregar más detalles según tu estructura de datos -->
    
    <!-- Ejemplo de tabla con resultados -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código del Documento</th>
                <th>Descripción</th>
                <!-- Agrega más columnas si es necesario -->
            </tr>
        </thead>
        <tbody>
            <!-- Aquí deberías agregar los resultados específicos -->
            <!-- Por ejemplo -->
            <tr>
                <td><?php echo htmlspecialchars($orden['id_documento']); ?></td>
                <!-- Asegúrate de que esta columna exista en tu base de datos -->
                <!-- Reemplaza con los datos correctos -->
                <td><?php echo htmlspecialchars($orden['descripcion']); ?></td> 
            </tr>            
        </tbody>
    </table>

    <!-- Botón para imprimir -->
    <button onclick="window.print();" class="btn btn-primary">Imprimir</button>
</div>

</body>
</html>
