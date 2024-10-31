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

// Check if order ID is provided
if (!isset($_GET['id'])) {
    header('Location: manage_orders.php');
    exit();
}

$order_id = $_GET['id'];

// Fetch order data
$stmt = $pdo->prepare("SELECT * FROM lab_m_orden WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: manage_orders.php');
    exit();
}

// Fetch patients for dropdown - CORRECCIÓN AQUÍ
$stmt = $pdo->query("
    SELECT t.id, p.nombre1, p.apellido1, p.numero_identificacion 
    FROM fac_m_tarjetero t
    INNER JOIN gen_m_persona p ON t.id_persona = p.id
    ORDER BY p.apellido1, p.nombre1
");
$patients = $stmt->fetchAll();

// Fetch available tests
$stmt = $pdo->query("SELECT id, nombre FROM lab_p_pruebas ORDER BY nombre");
$available_tests = $stmt->fetchAll();

// Fetch currently selected tests for this order
$stmt = $pdo->prepare("SELECT id_prueba FROM lab_m_orden_detalle WHERE id_orden = ?");
$stmt->execute([$order_id]);
$selected_tests = $stmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $order_date = $_POST['order_date'];
    $selected_tests = isset($_POST['tests']) ? $_POST['tests'] : [];

    // Validar que el patient_id existe en fac_m_tarjetero
    $stmt = $pdo->prepare("SELECT id FROM fac_m_tarjetero WHERE id = ?");
    $stmt->execute([$patient_id]);
    if (!$stmt->fetch()) {
        $error = "El paciente seleccionado no es válido.";
    } else {
        try {
            $pdo->beginTransaction();

            // Update order
            $stmt = $pdo->prepare("UPDATE lab_m_orden SET id_historia = ?, fecha = ? WHERE id = ?");
            $stmt->execute([$patient_id, $order_date, $order_id]);

            // Delete existing order details
            $stmt = $pdo->prepare("DELETE FROM lab_m_orden_detalle WHERE id_orden = ?");
            $stmt->execute([$order_id]);

            // Insert new order details
            $stmt = $pdo->prepare("INSERT INTO lab_m_orden_detalle (id_orden, id_prueba) VALUES (?, ?)");
            foreach ($selected_tests as $test_id) {
                $stmt->execute([$order_id, $test_id]);
            }

            $pdo->commit();
            $success = "Orden actualizada exitosamente.";
            
            // Recargar los datos actualizados
            $stmt = $pdo->prepare("SELECT * FROM lab_m_orden WHERE id = ?");
            $stmt->execute([$order_id]);
            $order = $stmt->fetch();
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Error al actualizar la orden: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Orden - Panel de Administración</title>
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

        .test-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .form-check {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .form-check:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

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
                        <a class="nav-link" href="manage_results.php">Gestionar Resultados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4 text-center animate__animated animate__fadeIn">Editar Orden</h1>
        <div class="card animate__animated animate__fadeInUp">
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger animate__animated animate__shakeX"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success animate__animated animate__bounceIn"><?php echo $success; ?></div>
                <?php endif; ?>
                <form action="edit_order.php?id=<?php echo $order_id; ?>" method="post" id="editOrderForm">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Paciente</label>
                        <select class="form-select" id="patient_id" name="patient_id" required>
                            <option value="">Seleccione un paciente</option>
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?php echo $patient['id']; ?>" <?php echo ($order['id_historia'] == $patient['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($patient['apellido1'] . ' ' . $patient['nombre1'] . ' (' . $patient['numero_identificacion'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="order_date" class="form-label">Fecha de Orden</label>
                        <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo htmlspecialchars($order['fecha'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pruebas</label>
                        <div class="test-grid">
                            <?php foreach ($available_tests as $test): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $test['id']; ?>" id="test_<?php echo $test['id']; ?>" name="tests[]" <?php echo in_array($test['id'], $selected_tests) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="test_<?php echo $test['id']; ?>">
                                        <?php echo htmlspecialchars($test['nombre']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Actualizar Orden
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

        // Show loading overlay during form submission
        document.getElementById('editOrderForm').addEventListener('submit', function(e) {
            document.querySelector('.loading-overlay').style.display = 'flex';
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalContent = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualizando...';
            submitButton.disabled = true;

            // Re-enable the button after 2 seconds (adjust as needed)
            setTimeout(() => {
                submitButton.innerHTML = originalContent;
                submitButton.disabled = false;
                document.querySelector('.loading-overlay').style.display = 'none';
            }, 2000);
        });
    </script>
</body>
</html>