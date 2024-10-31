<?php
session_start();
include 'config/db_connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_id = $_POST['tipo_id'] ?? '';
    $num_id = $_POST['num_id'];
    $fecha_nac = $_POST['fecha_nac'];

    $stmt = $pdo->prepare("SELECT * FROM gen_m_persona WHERE tipo_identificacion = ? AND numero_identificacion = ? AND fecha_nacimiento = ?");
    $stmt->execute([$tipo_id, $num_id, $fecha_nac]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre1'] . ' ' . $user['apellido1'];

        if ($user['rol'] == 'admin') {
            $_SESSION['is_admin'] = true;
            header('Location: admin/index.php');
        } else {
            $_SESSION['is_admin'] = false;
            header('Location: index_user.php'); // Cambiado a index_user.php
        }
        exit();
    } else {
        $error = 'Credenciales inválidas. Por favor, intente de nuevo.';
    }
}

$stmt = $pdo->query("SELECT * FROM gen_p_lista_opcion WHERE categoria = 'TipoIdentificacion'");
$tiposIdentificacion = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="container main-content">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card animate__animated animate__fadeInUp">
                <div class="card-header py-3">
                    <h2 class="text-center mb-0">
                        <i class="fas fa-user-lock me-2"></i>
                        Iniciar sesión
                    </h2>
                </div>
                <div class="card-body">
                    <?php if($error): ?>
                        <div class="alert alert-danger animate__animated animate__shake">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="login.php" method="post" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="tipo_id" class="form-label">
                                <i class="fas fa-id-card me-2"></i>
                                Tipo de identificación
                            </label>
                            <select class="form-select form-control-lg" id="tipo_id" name="tipo_id" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($tiposIdentificacion as $tipo): ?>
                                    <option value="<?php echo htmlspecialchars($tipo['nombre']); ?>">
                                        <?php echo htmlspecialchars($tipo['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="num_id" class="form-label">
                                <i class="fas fa-hashtag me-2"></i>
                                Número de identificación
                            </label>
                            <input type="text" class="form-control form-control-lg" id="num_id" name="num_id" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="fecha_nac" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Fecha de nacimiento
                            </label>
                            <input type="date" class="form-control form-control-lg" id="fecha_nac" name="fecha_nac" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg pulse-button">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Iniciar sesión
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i>
                                Volver al inicio
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>