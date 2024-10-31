<?php
session_start();
include '../config/db_connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}

// Fetch some basic statistics for the admin dashboard
$stmt = $pdo->query("SELECT COUNT(*) as total_patients FROM gen_m_persona");
$total_patients = $stmt->fetch()['total_patients'];

$stmt = $pdo->query("SELECT COUNT(*) as total_orders FROM lab_m_orden");
$total_orders = $stmt->fetch()['total_orders'];

$stmt = $pdo->query("SELECT COUNT(*) as total_results FROM lab_m_orden_resultados");
$total_results = $stmt->fetch()['total_results'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sistema de Laboratorio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #3a7bc8;
            --background-color: #f0f8ff;
        }

        body {
            background-color: var(--background-color);
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: var(--primary-color) !important;
        }

        .navbar-brand, .nav-link {
            color: white !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
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
    </style>
</head>
<body>
    <div id="particles-js" class="particles-container"></div>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Panel de Administración</a>
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
                            <a class="nav-link active" href="manage_tests.php">Gestionar Pruebas</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 main-content">
        <h1 class="mb-4 text-center animate__animated animate__fadeIn">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card animate__animated animate__fadeInUp">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Total de Pacientes</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="card-text"><?php echo $total_patients; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Total de Órdenes</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="card-text"><?php echo $total_orders; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Total de Resultados</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="card-text"><?php echo $total_results; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
            <div class="card-header">
                <h2 class="mb-0">Acciones Rápidas</h2>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="manage_patients.php" class="btn btn-link"><i class="fas fa-user-injured"></i> Gestionar Pacientes</a></li>
                    <li class="list-group-item"><a href="manage_orders.php" class="btn btn-link"><i class="fas fa-file-medical"></i> Gestionar Órdenes</a></li>
                    <li class="list-group-item"><a href="manage_results.php" class="btn btn-link"><i class="fas fa-vial"></i> Gestionar Resultados</a></li>
                    <li class="list-group-item"><a href="manage_tests.php" class="btn btn-link"><i class="fas fa-microscope"></i> Gestionar Pruebas</a></li>
                </ul>
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
        });
    </script>
</body>
</html>