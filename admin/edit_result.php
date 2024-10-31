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

// Check if result ID is provided
if (!isset($_GET['id'])) {
    header('Location: manage_results.php');
    exit();
}

$result_id = $_GET['id'];

// Fetch result data
$stmt = $pdo->prepare("SELECT r.*, o.orden, p.nombre1, p.apellido1, p.numero_identificacion, pr.nombre as prueba_nombre
                       FROM lab_m_orden_resultados r
                       JOIN lab_m_orden o ON r.id_orden = o.id
                       JOIN fac_m_tarjetero t ON o.id_historia = t.id
                       JOIN gen_m_persona p ON t.id_persona = p.id
                       JOIN lab_p_pruebas pr ON r.id_prueba = pr.id
                       WHERE r.id = ?");
$stmt->execute([$result_id]);
$result = $stmt->fetch();

if (!$result) {
    header('Location: manage_results.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $res_opcion = $_POST['res_opcion'] ?? null;
    $res_numerico = $_POST['res_numerico'] ?? null;
    $res_texto = $_POST['res_texto'] ?? null;
    $res_memo = $_POST['res_memo'] ?? null;

    try {
        $stmt = $pdo->prepare("UPDATE lab_m_orden_resultados SET res_opcion = ?, res_numerico = ?, res_texto = ?, res_memo = ? WHERE id = ?");
        $stmt->execute([$res_opcion, $res_numerico, $res_texto, $res_memo, $result_id]);
        $success = "Resultado actualizado exitosamente.";
    } catch (PDOException $e) {
        $error = "Error al actualizar el resultado: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Resultado - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #3498DB;
            --accent-color: #E74C3C;
            --background-color: #ECF0F1;
            --card-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            background-color: var(--background-color);
            color: var(--primary-color);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            position: relative;
        }

        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .main-content {
            position: relative;
            z-index: 1;
        }

        .navbar {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color)) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand, .nav-link {
            color: white !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .card {
            background: var(--card-bg);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="particles-js" class="particles-container"></div>

    <div class="main-content">
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
                            <a class="nav-link" href="manage_tests.php">Gestionar Pruebas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            <h1 class="mb-4 animate__animated animate__fadeIn">Editar Resultado</h1>
            <div class="card mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger animate__animated animate__shakeX"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success animate__animated animate__bounceIn"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <form action="edit_result.php?id=<?php echo $result_id; ?>" method="post" id="editResultForm">
                        <div class="mb-3">
                            <label class="form-label">Orden: <?php echo htmlspecialchars($result['orden']); ?></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Paciente: <?php echo htmlspecialchars($result['nombre1'] . ' ' . $result['apellido1'] . ' (' . $result['numero_identificacion'] . ')'); ?></label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prueba: <?php echo htmlspecialchars($result['prueba_nombre']); ?></label>
                        </div>
                        <div class="mb-3">
                            <label for="resultado" class="form-label">Resultado:</label>
                            <input type="text" class="form-control" id="res_opcion" name="res_opcion" value="<?php echo htmlspecialchars($result['res_opcion'] ?? ''); ?>" placeholder="Resultado de opción">
                            <input type="number" step="0.01" class="form-control mt-2" id="res_numerico" name="res_numerico" value="<?php echo htmlspecialchars($result['res_numerico'] ?? ''); ?>" placeholder="Resultado numérico">
                            <input type="text" class="form-control mt-2" id="res_texto" name="res_texto" value="<?php echo htmlspecialchars($result['res_texto'] ?? ''); ?>" placeholder="Resultado de texto">
                            <textarea class="form-control mt-2" id="res_memo" name="res_memo" rows="4" placeholder="Resultado memo"><?php echo htmlspecialchars($result['res_memo'] ?? ''); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                particles: {
                    number: { value: 80, density: { enable: true, value_area: 800 } },
                    color: { value: '#3498db' },
                    shape: { type: 'circle' },
                    opacity: { value: 0.5, random: false },
                    size: { value: 3, random: true },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: '#3498db',
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

            // Add loading effect to submit button
            document.getElementById('editResultForm').addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                const originalContent = submitButton.innerHTML;
                submitButton.innerHTML = '<div class="loading-spinner"></div>';
                submitButton.disabled = true;

                // Re-enable the button after 2 seconds (adjust as needed)
                setTimeout(() => {
                    submitButton.innerHTML = originalContent;
                    submitButton.disabled = false;
                }, 2000);
            });
        });
    </script>
</body>
</html>