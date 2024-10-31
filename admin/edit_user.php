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

// Fetch tipos de identificación
$stmt = $pdo->query("SELECT * FROM gen_p_lista_opcion WHERE categoria = 'TipoIdentificacion'");
$tiposIdentificacion = $stmt->fetchAll();

// Check if user ID is provided
if (!isset($_GET['id'])) {
    header('Location: manage_users.php');
    exit();
}

$user_id = $_GET['id'];

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM gen_m_persona WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: manage_users.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_id = $_POST['tipo_id'];
    $num_id = $_POST['num_id'];
    $nombre1 = $_POST['nombre1'];
    $nombre2 = $_POST['nombre2'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $fecha_nac = $_POST['fecha_nac'];
    $sexo = $_POST['sexo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    try {
        $stmt = $pdo->prepare("UPDATE gen_m_persona SET tipo_identificacion = ?, numero_identificacion = ?, nombre1 = ?, nombre2 = ?, apellido1 = ?, apellido2 = ?, fecha_nacimiento = ?, sexo_biologico = ?, direccion = ?, telefono_movil = ?, email = ? WHERE id = ?");
        $stmt->execute([$tipo_id, $num_id, $nombre1, $nombre2, $apellido1, $apellido2, $fecha_nac, $sexo, $direccion, $telefono, $email, $user_id]);
        $success = "Usuario actualizado exitosamente.";
    } catch (PDOException $e) {
        $error = "Error al actualizar usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Panel de Administración</title>
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
        <h1 class="mb-4 text-center animate__animated animate__fadeIn">Editar Usuario</h1>
        <div class="card animate__animated animate__fadeInUp">
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger animate__animated animate__shakeX"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success animate__animated animate__bounceIn"><?php echo $success; ?></div>
                <?php endif; ?>
                <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post" id="editUserForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo_id" class="form-label">Tipo de Identificación</label>
                            <select class="form-select" id="tipo_id" name="tipo_id" required>
                                <?php foreach ($tiposIdentificacion as $tipo): ?>
                                    <option value="<?php echo htmlspecialchars($tipo['nombre']); ?>" <?php echo ($user['tipo_identificacion'] == $tipo['nombre']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tipo['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="num_id" class="form-label">Número de Identificación</label>
                            <input type="text" class="form-control" id="num_id" name="num_id" value="<?php echo htmlspecialchars($user['numero_identificacion']); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre1" class="form-label">Primer Nombre</label>
                            <input type="text" class="form-control" id="nombre1" name="nombre1" value="<?php echo htmlspecialchars($user['nombre1']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombre2" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" id="nombre2" name="nombre2" value="<?php echo htmlspecialchars($user['nombre2']); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="apellido1" class="form-label">Primer Apellido</label>
                            <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo htmlspecialchars($user['apellido1']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido2" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo htmlspecialchars($user['apellido2']); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="<?php echo htmlspecialchars($user['fecha_nacimiento']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sexo" class="form-label">Sexo Biológico</label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="Masculino" <?php echo ($user['sexo_biologico'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="Femenino" <?php echo ($user['sexo_biologico'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                                <option value="Otro" <?php echo ($user['sexo_biologico'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($user['direccion']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono Móvil</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono_movil']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Actualizar Usuario
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

        // Add loading spinner to submit button
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalContent = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualizando...';
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