<?php
include 'config/db_connection.php';

echo "<h1>Página de Depuración</h1>";

// Verificar la conexión a la base de datos
echo "<h2>1. Verificación de la conexión a la base de datos:</h2>";
try {
    $pdo->query("SELECT 1");
    echo "<p style='color: green;'>La conexión a la base de datos es exitosa.</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error de conexión: " . $e->getMessage() . "</p>";
}

// Mostrar los datos de la tabla gen_m_persona
echo "<h2>2. Contenido de la tabla gen_m_persona:</h2>";
try {
    $stmt = $pdo->query("SELECT * FROM gen_m_persona");
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($personas) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Tipo ID</th><th>Número ID</th><th>Nombre</th><th>Apellido</th><th>Fecha Nacimiento</th></tr>";
        foreach ($personas as $persona) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($persona['id']) . "</td>";
            echo "<td>" . htmlspecialchars($persona['tipo_identificacion']) . "</td>";
            echo "<td>" . htmlspecialchars($persona['numero_identificacion']) . "</td>";
            echo "<td>" . htmlspecialchars($persona['nombre1']) . "</td>";
            echo "<td>" . htmlspecialchars($persona['apellido1']) . "</td>";
            echo "<td>" . htmlspecialchars($persona['fecha_nacimiento']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay datos en la tabla gen_m_persona.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error al obtener datos: " . $e->getMessage() . "</p>";
}

// Formulario de prueba de login
echo "<h2>3. Prueba de login:</h2>";
echo "<form action='debug.php' method='post'>";
echo "Tipo de ID: <input type='text' name='tipo_id'><br>";
echo "Número de ID: <input type='text' name='num_id'><br>";
echo "Fecha de nacimiento (YYYY-MM-DD): <input type='text' name='fecha_nac'><br>";
echo "<input type='submit' value='Probar Login'>";
echo "</form>";

// Procesar el formulario de prueba
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_id = $_POST['tipo_id'];
    $num_id = $_POST['num_id'];
    $fecha_nac = $_POST['fecha_nac'];

    echo "<h3>Resultados de la prueba:</h3>";
    echo "Datos ingresados:<br>";
    echo "Tipo ID: " . htmlspecialchars($tipo_id) . "<br>";
    echo "Número ID: " . htmlspecialchars($num_id) . "<br>";
    echo "Fecha de nacimiento: " . htmlspecialchars($fecha_nac) . "<br><br>";

    $stmt = $pdo->prepare("SELECT * FROM gen_m_persona WHERE tipo_identificacion = ? AND numero_identificacion = ? AND fecha_nacimiento = ?");
    $stmt->execute([$tipo_id, $num_id, $fecha_nac]);
    $user = $stmt->fetch();

    if ($user) {
        echo "<p style='color: green;'>Usuario encontrado. Login exitoso.</p>";
        echo "Datos del usuario:<br>";
        print_r($user);
    } else {
        echo "<p style='color: red;'>Usuario no encontrado. Credenciales inválidas.</p>";
        echo "Consulta SQL ejecutada: " . $stmt->queryString . "<br>";
        echo "Parámetros: " . implode(", ", [$tipo_id, $num_id, $fecha_nac]) . "<br>";
    }
}
?>