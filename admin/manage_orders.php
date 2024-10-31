<?php
session_start();
include '../config/db_connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}

// Fetch orders
$stmt = $pdo->query("SELECT o.*, p.nombre1, p.apellido1, p.numero_identificacion 
                     FROM lab_m_orden o 
                     JOIN fac_m_tarjetero t ON o.id_historia = t.id
                     JOIN gen_m_persona p ON t.id_persona = p.id
                     ORDER BY o.fecha DESC");
$orders = $stmt->fetchAll();

// Handle order deletion
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    $stmt = $pdo->prepare("DELETE FROM lab_m_orden WHERE id = ?");
    $stmt->execute([$order_id]);
    header('Location: manage_orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Órdenes - Panel de Administración</title>
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

        .table {
            background-color: var(--card-bg);
            border-radius: 15px;
            overflow: hidden;
        }

        .table th {
            background-color: var(--secondary-color);
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.1);
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
                            <a class="nav-link active" href="manage_orders.php">Gestionar Órdenes</a>
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

        <div class="container mt-5">
            <h1 class="mb-4 animate__animated animate__fadeIn">Gestionar Órdenes</h1>
            <div class="card mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <a href="add_order.php" class="btn btn-primary mb-3 pulse-button">
                        <i class="fas fa-plus"></i> Agregar Nueva Orden
                    </a>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Paciente</th>
                                    <th>Número de Orden</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr class="animate__animated animate__fadeIn">
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['fecha']); ?></td>
                                    <td><?php echo htmlspecialchars($order['nombre1'] . ' ' . $order['apellido1'] . ' (' . $order['numero_identificacion'] . ')'); ?></td>
                                    <td><?php echo htmlspecialchars($order['orden']); ?></td>
                                    <td>
                                        <a href="edit_order.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="manage_orders.php" method="post" class="d-inline">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <button type="submit" name="delete_order" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta orden?')">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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

            // Add loading effect to buttons
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.classList.contains('btn-danger')) {
                        const originalContent = this.innerHTML;
                        this.innerHTML = '<div class="loading-spinner"></div>';
                        setTimeout(() => {
                            this.innerHTML = originalContent;
                        }, 1000);
                    }
                });
            });
        });
    </script>
</body>
</html>