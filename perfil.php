<?php
session_start();
include 'config/db_connection.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM gen_m_persona WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<div class="particles-container" id="particles-js"></div>

<div class="container main-content">
    <h2 class="mt-5 text-center text-primary animate__animated animate__fadeIn">Perfil del Paciente</h2>
    <div class="card welcome-card animate__animated animate__fadeInUp">
        <div class="card-body">
            <h5 class="card-title text-center mb-4"><?php echo $user['nombre1'] . ' ' . $user['apellido1']; ?></h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text"><strong><i class="fas fa-id-card"></i> Tipo de identificación:</strong> <?php echo $user['tipo_identificacion']; ?></p>
                    <p class="card-text"><strong><i class="fas fa-fingerprint"></i> Número de identificación:</strong> <?php echo $user['numero_identificacion']; ?></p>
                    <p class="card-text"><strong><i class="fas fa-birthday-cake"></i> Fecha de nacimiento:</strong> <?php echo $user['fecha_nacimiento']; ?></p>
                    <p class="card-text"><strong><i class="fas fa-venus-mars"></i> Sexo biológico:</strong> <?php echo $user['sexo_biologico']; ?></p>
                </div>
                <div class="col-md-6">
                    <p class="card-text"><strong><i class="fas fa-home"></i> Dirección:</strong> <?php echo $user['direccion']; ?></p>
                    <p class="card-text"><strong><i class="fas fa-mobile-alt"></i> Teléfono móvil:</strong> <?php echo $user['telefono_movil']; ?></p>
                    <p class="card-text"><strong><i class="fas fa-envelope"></i> Email:</strong> <?php echo $user['email']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Particles.js configuration
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

    // Add hover effect to card
    const card = document.querySelector('.welcome-card');
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-5px)';
        card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
        card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
    });
});
</script>

<style>
:root {
    --primary-color: #3498db;
    --secondary-color: #2c3e50;
    --background-color: #ecf0f1;
}

body {
    background-color: var(--background-color);
    font-family: 'Poppins', sans-serif;
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
    padding: 2rem 0;
}

h2 {
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.welcome-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border: none;
    padding: 2rem;
    margin-top: 2rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-title {
    color: var(--secondary-color);
    font-weight: 600;
}

.card-text {
    margin-bottom: 1rem;
}

.card-text i {
    color: var(--primary-color);
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    h2 {
        font-size: 1.8rem;
    }
    
    .welcome-card {
        padding: 1.5rem;
    }
}
</style>