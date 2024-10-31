<?php
session_start();
include '../config/db_connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';

// Fetch orders for the dropdown
$stmt = $pdo->query("SELECT o.id, o.orden, p.nombre1, p.apellido1, p.numero_identificacion 
                     FROM lab_m_orden o 
                     JOIN fac_m_tarjetero t ON o.id_historia = t.id
                     JOIN gen_m_persona p ON t.id_persona = p.id
                     ORDER BY o.fecha DESC");
$orders = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $test_id = $_POST['test_id'];
    $result_value = $_POST['result_value'];
    $result_type = $_POST['result_type'];

    try {
        $stmt = $pdo->prepare("INSERT INTO lab_m_orden_resultados (id_orden, id_prueba, res_opcion, res_numerico, res_texto, res_memo) VALUES (?, ?, ?, ?, ?, ?)");
        
        $res_opcion = $result_type == 'opcion' ? $result_value : null;
        $res_numerico = $result_type == 'numerico' ? $result_value : null;
        $res_texto = $result_type == 'texto' ? $result_value : null;
        $res_memo = $result_type == 'memo' ? $result_value : null;

        $stmt->execute([$order_id, $test_id, $res_opcion, $res_numerico, $res_texto, $res_memo]);
        $success = "Resultado agregado exitosamente.";
    } catch (PDOException $e) {
        $error = "Error al agregar el resultado: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Resultado - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f0f8ff;
            --accent-color: #e74c3c;
            --text-color: #333;
            --background-color: #f0f8ff;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), #2c3e50) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand, .nav-link {
            color: white !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3a7bc8;
            border-color: #3a7bc8;
            transform: translateY(-2px);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .alert {
            border-radius: 10px;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Panel de Administración</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_patients.php">Gestionar Pacientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_orders.php">Gestionar Órdenes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manage_results.php">Gestionar Resultados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4 text-center animate__animated animate__fadeIn">Agregar Nuevo Resultado</h1>
        <div class="card animate__animated animate__fadeInUp">
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger animate__animated animate__shakeX"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success animate__animated animate__bounceIn"><?php echo $success; ?></div>
                <?php endif; ?>
                <form action="add_result.php" method="post" id="addResultForm">
                    <div class="mb-3">
                        <label for="order_id" class="form-label">Orden</label>
                        <select class="form-select" id="order_id" name="order_id" required>
                            <option value="">Seleccione una orden...</option>
                            <?php foreach ($orders as $order): ?>
                                <option value="<?php echo $order['id']; ?>">
                                    <?php echo htmlspecialchars($order['orden'] . ' - ' . $order['nombre1'] . ' ' . $order['apellido1'] . ' (' . $order['numero_identificacion'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="test_id" class="form-label">Prueba</label>
                        <select class="form-select" id="test_id" name="test_id" required>
                            <option value="">Seleccione una prueba...</option>
                            <!-- Las opciones se cargarán dinámicamente con JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="result_type" class="form-label">Tipo de Resultado</label>
                        <select class="form-select" id="result_type" name="result_type" required>
                            <option value="opcion">Opción</option>
                            <option value="numerico">Numérico</option>
                            <option value="texto">Texto</option>
                            <option value="memo">Memo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="result_value" class="form-label">Valor del Resultado</label>
                        <input type="text" class="form-control" id="result_value" name="result_value" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus-circle"></i> Agregar Resultado
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: '#4a90e2' },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#4a90e2',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: true, mode: 'grab' },
                    onclick: { enable: true, mode: 'push' },
                    resize: true
                }
            },
            retina_detect: true
        });

        function updateResultValueField() {
            const resultType = document.getElementById('result_type').value;
            const resultValueInput = document.getElementById('result_value');
            
            switch(resultType) {
                case 'opcion':
                    resultValueInput.type = 'text';
                    resultValueInput.placeholder = 'Ingrese una opción (ej: Positivo/Negativo)';
                    break;
                case 'numerico':
                    resultValueInput.type = 'number';
                    resultValueInput.step = 'any';
                    resultValueInput.placeholder = 'Ingrese un valor numérico';
                    break;
                case 'texto':
                    resultValueInput.type = 'text';
                    resultValueInput.placeholder = 'Ingrese el texto del resultado';
                    break;
                case 'memo':
                    if (resultValueInput.tagName !== 'TEXTAREA') {
                        const textarea = document.createElement('textarea');
                        textarea.id = 'result_value';
                        textarea.name = 'result_value';
                        textarea.className = 'form-control';
                        textarea.placeholder = 'Ingrese la descripción detallada';
                        textarea.required = true;
                        resultValueInput.parentNode.replaceChild(textarea, resultValueInput);
                    }
                    break;
            }
        }

        document.getElementById('result_type').addEventListener('change', updateResultValueField);

        document.getElementById('order_id').addEventListener('change', function() {
            const orderId = this.value;
            const testSelect = document.getElementById('test_id');
            
            if (orderId) {
                testSelect.innerHTML = '<option value="">Cargando pruebas...</option>';
                testSelect.disabled = true;
                
                fetch(`get_tests_for_order.php?order_id=${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        testSelect.disabled = false;
                        
                        if (data.error) {
                            throw new Error(data.error);
                        }
                        
                        if (data.length === 0) {
                            testSelect.innerHTML = '<option value="">No hay pruebas pendientes para esta orden</option>';
                            return;
                        }
                        
                        testSelect.innerHTML = '<option value="">Seleccione una prueba...</option>';
                        data.forEach(test => {
                            const option = document.createElement('option');
                            option.value = test.id;
                            option.textContent = test.nombre;
                            testSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        testSelect.innerHTML = '<option value="">Error al cargar las pruebas</option>';
                        testSelect.disabled = false;
                        alert('Error al cargar las pruebas: ' + error.message);
                    });
            } else {
                testSelect.innerHTML = '<option value="">Seleccione una orden primero...</option>';
            }
        });

        updateResultValueField();

        // Add loading spinner to submit button
        document.getElementById('addResultForm').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalContent = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agregando...';
            submitButton.disabled = true;

            // Re-enable the button after 2 seconds (adjust as needed)
            setTimeout(() => {
                submitButton.innerHTML = originalContent;
                submitButton.disabled = false;
            }, 2000);
        });
    </script>
</body>
</html>