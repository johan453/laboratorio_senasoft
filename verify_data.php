<?php
include 'config/db_connection.php';

echo "<h2>Verificación de datos</h2>";

// Verificar tipos de identificación
$stmt = $pdo->query("SELECT * FROM gen_p_lista_opcion WHERE categoria = 'TipoIdentificacion'");
$tiposIdentificacion = $stmt->fetchAll();

echo "<h3>Tipos de identificación disponibles:</h3>";
foreach ($tiposIdentificacion as $tipo) {
    echo "ID: " . $tipo['id'] . ", Nombre: " . $tipo['nombre'] . "<br>";
}

// Verificar datos de personas
$stmt = $pdo->query("SELECT * FROM gen_m_persona LIMIT 10");
$personas = $stmt->fetchAll();

echo "<h3>Primeras 10 personas en la base de datos:</h3>";
foreach ($personas as $persona) {
    echo "ID: " . $persona['id'] . 
         ", Tipo ID: " . $persona['tipo_identificacion'] . 
         ", Número ID: " . $persona['numero_identificacion'] . 
         ", Fecha Nac: " . $persona['fecha_nacimiento'] . 
         ", Nombre: " . $persona['nombre1'] . " " . $persona['apellido1'] . "<br>";
}

// Verificar formato de fechas
$stmt = $pdo->query("SELECT DISTINCT fecha_nacimiento FROM gen_m_persona");
$fechas = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "<h3>Formatos de fecha de nacimiento en uso:</h3>";
foreach ($fechas as $fecha) {
    echo $fecha . "<br>";
}
?>