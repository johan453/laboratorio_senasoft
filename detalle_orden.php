<?php
session_start();
include 'config/db_connection.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: login.php');
    exit();
}

$orden_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT o.*, d.nombre as documento_nombre 
                       FROM lab_m_orden o 
                       JOIN gen_p_documento d ON o.id_documento = d.id 
                       WHERE o.id = ?");
$stmt->execute([$orden_id]);
$orden = $stmt->fetch();

if (!$orden) {
    echo "Orden no encontrada.";
    exit();
}

$stmt = $pdo->prepare("SELECT r.*, p.nombre as prueba_nombre, pr.nombre as procedimiento_nombre, g.nombre as grupo_nombre 
                       FROM lab_m_orden_resultados r 
                       JOIN lab_p_pruebas p ON r.id_prueba = p.id 
                       JOIN lab_p_procedimientos pr ON r.id_procedimiento = pr.id 
                       JOIN lab_p_grupos g ON pr.id_grupo_laboratorio = g.id 
                       WHERE r.id_orden = ?
                       ORDER BY g.nombre, pr.nombre, p.nombre");
$stmt->execute([$orden_id]);
$resultados = $stmt->fetchAll();

$grupos = [];
foreach ($resultados as $resultado) {
    $grupos[$resultado['grupo_nombre']][$resultado['procedimiento_nombre']][] = $resultado;
}
?>

<div class="particles-container" id="particles-js"></div>

<div class="container main-content">
    <h2 class="mt-5 text-center text-primary animate__animated animate__fadeIn">Detalle de la Orden</h2>
    <div class="card welcome-card animate__animated animate__fadeInUp mb-4">
        <div class="card-body">
            <h5 class="card-title">Orden #<?php echo htmlspecialchars($orden['orden']); ?></h5>
            <p class="card-text"><strong>Fecha:</strong> <?php echo htmlspecialchars($orden['fecha']); ?></p>
            <p class="card-text"><strong>Documento:</strong> <?php echo htmlspecialchars($orden['documento_nombre']); ?></p>
        </div>
    </div>

    <?php foreach ($grupos as $grupo_nombre => $procedimientos): ?>
        <div class="card welcome-card animate__animated animate__fadeInUp mb-4">
            <div class="card-header">
                <h3 class="mb-0"><?php echo htmlspecialchars($grupo_nombre); ?></h3>
            </div>
            <div class="card-body">
                <?php foreach ($procedimientos as $procedimiento_nombre => $pruebas): ?>
                    <h4 class="mt-3"><?php echo htmlspecialchars($procedimiento_nombre); ?></h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Prueba</th>
                                    <th>Resultado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pruebas as $prueba): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($prueba['prueba_nombre']); ?></td>
                                        <td>
                                            <?php
                                            if ($prueba['res_opcion']) {
                                                echo htmlspecialchars($prueba['res_opcion']);
                                            } elseif ($prueba['res_numerico'] !== null) {
                                                echo htmlspecialchars($prueba['res_numerico']);
                                            } elseif ($prueba['res_texto']) {
                                                echo htmlspecialchars($prueba['res_texto']);
                                            } elseif ($prueba['res_memo']) {
                                                echo htmlspecialchars($prueba['res_memo']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>

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

    const cards = document.querySelectorAll('.welcome-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
        });
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

h2, h3, h4 {
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.welcome-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-header {
    background-color: var(--primary-color);
    color: white;
    border-radius: 15px 15px 0 0;
}

.table {
    background-color: white;
}

.table-hover tbody tr:hover {
    background-color: rgba(52, 152, 219, 0.1);
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