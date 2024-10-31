<?php
session_start();
// Verificar si el usuario está autenticado
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'includes/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card welcome-card animate__animated animate__fadeIn">
                <div class="card-body">
                    <h2 class="text-primary">
                        <i class="fas fa-user-circle me-2"></i>
                        Bienvenido(a), <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Panel de Resultados Recientes -->
        <div class="col-md-6">
            <div class="card mb-4 animate__animated animate__fadeInLeft">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-file-medical me-2"></i>
                        Resultados Recientes
                    </h3>
                </div>
                <div class="card-body">
                    <a href="resultados.php" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="fas fa-microscope me-2"></i>
                        Ver mis resultados
                    </a>
                </div>
            </div>
        </div>

        <!-- Panel de Acciones Rápidas -->
        <div class="col-md-6">
            <div class="card mb-4 animate__animated animate__fadeInRight">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-star me-2"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="perfil.php" class="btn btn-outline-primary">
                            <i class="fas fa-user-edit me-2"></i>
                            Actualizar Perfil
                        </a>
                        <a href="logout.php" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Avisos o Noticias -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card animate__animated animate__fadeInUp">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>
                        Avisos Importantes
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Recuerda que puedes consultar tus resultados las 24 horas del día.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>