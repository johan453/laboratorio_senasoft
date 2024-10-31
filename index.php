<?php
session_start();
// Si el usuario ya está autenticado, redirir a index_user.php
if(isset($_SESSION['user_id'])) {
    header('Location: index_user.php');
    exit();
}
include 'includes/header.php';
?>

<!-- Cargar librerías de animación -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

<style>
    /* Fondo animado con degradado */
    body {
        background: linear-gradient(120deg, #3498db, #8e44ad);
        background-size: 400% 400%;
        animation: gradientAnimation 10s ease infinite;
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Animación de botón pulsante */
    .pulse-button {
        position: relative;
        animation: pulseAnimation 2s infinite;
    }

    @keyframes pulseAnimation {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* Animación hover para las tarjetas de características */
    .feature-card:hover {
        transform: translateY(-10px);
        transition: transform 0.3s ease-in-out;
        box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Colores y estilo personalizado para tarjetas */
    .feature-card {
        background: #fff;
        border: none;
        border-radius: 15px;
        transition: all 0.4s ease;
    }

    .feature-card i {
        animation: bounceIcon 1.5s infinite;
    }

    @keyframes bounceIcon {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    /* Texto animado en la página de bienvenida */
    h1 {
        font-size: 3rem;
        color: #fff;
        animation: fadeInDown 1.5s ease;
    }

    p.lead {
        font-size: 1.5rem;
        color: #f1f1f1;
        animation: fadeInUp 2s ease;
    }

    /* Tabla de resultados */
    .results-table {
        width: 100%;
        background: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-top: 50px;
        padding: 20px;
        animation: fadeInUp 1.5s ease;
    }

    .results-table th, .results-table td {
        padding: 15px;
        text-align: left;
    }

    /* Sección de testimonios */
    .testimonial {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 20px 0;
        transition: all 0.3s ease;
    }

    .testimonial:hover {
        transform: scale(1.05);
    }

    /* Preguntas frecuentes */
    .faq-section {
        margin-top: 50px;
    }

    .faq-title {
        font-size: 1.8rem;
        margin-bottom: 20px;
        color: #fff;
    }

    .faq-item {
        margin-bottom: 20px;
    }

    .faq-item h5 {
        font-weight: bold;
        color: #fff;
    }

    .faq-item p {
        color: #e0e0e0;
    }
</style>

<div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-lg-8 text-center">
            <h1 class="mt-5 animate__animated animate__fadeInDown">Bienvenido al Portal de Resultados de Laboratorio</h1>
            <p class="lead animate__animated animate__fadeInUp">Aquí podrás consultar tus resultados de laboratorio de manera fácil y segura.</p>
            <div class="mt-4">
                <a href="login.php" class="btn btn-primary btn-lg pulse-button">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Iniciar sesión
                </a>
            </div>

            <!-- Características del servicio -->
            <div class="row mt-5">
                <div class="col-md-4" data-aos="flip-left">
                    <div class="card feature-card mb-4">
                        <div class="card-body">
                            <i class="fas fa-shield-alt text-primary mb-3" style="font-size: 2rem;"></i>
                            <h3>Seguro</h3>
                            <p>Tus datos están protegidos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-right">
                    <div class="card feature-card mb-4">
                        <div class="card-body">
                            <i class="fas fa-bolt text-primary mb-3" style="font-size: 2rem;"></i>
                            <h3>Rápido</h3>
                            <p>Acceso inmediato a tus resultados</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-left">
                    <div class="card feature-card mb-4">
                        <div class="card-body">
                            <i class="fas fa-clock text-primary mb-3" style="font-size: 2rem;"></i>
                            <h3>24/7</h3>
                            <p>Disponible en todo momento</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Resultados -->
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-lg-10">
            <h2 class="mt-5 text-center text-white">Resultados Recientes</h2>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>ID del Resultado</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Tipo de Prueba</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>Juan Pérez</td>
                        <td>20/10/2024</td>
                        <td>Sangre</td>
                        <td>Completado</td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>María Gómez</td>
                        <td>18/10/2024</td>
                        <td>Orina</td>
                        <td>En Proceso</td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Carlos López</td>
                        <td>15/10/2024</td>
                        <td>Rayos X</td>
                        <td>Completado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Testimonios -->
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-lg-8">
            <h2 class="mt-5 text-center text-white">Testimonios de Usuarios</h2>
            <div class="testimonial">
                <p><strong>Juan Pérez:</strong> "El portal es muy fácil de usar y obtuve mis resultados rápidamente. Definitivamente lo recomiendo."</p>
            </div>
            <div class="testimonial">
                <p><strong>María Gómez:</strong> "La seguridad y rapidez del servicio es increíble. Me siento tranquila sabiendo que mis datos están protegidos."</p>
            </div>
        </div>
    </div>

    <!-- Preguntas Frecuentes -->
    <div class="faq-section" data-aos="fade-up">
        <h2 class="faq-title text-center">Preguntas Frecuentes</h2>
        <div class="row">
            <div class="col-md-6 faq-item">
                <h5>¿Cómo accedo a mis resultados?</h5>
                <p>Puedes acceder a tus resultados iniciando sesión con tu usuario y contraseña.</p>
            </div>
            <div class="col-md-6 faq-item">
                <h5>¿Qué pruebas están disponibles?</h5>
                <p>Ofrecemos resultados de sangre, orina, rayos X y más.</p>
            </div>
        </div>
    </div>
</div>

<!-- Cargar librerías de animación -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<?php
include 'includes/footer.php';
?>