<?php
session_start();
include 'config/db_connection.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$orderBy = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'ASC' : 'DESC';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

$whereClause = "WHERE t.id_persona = :user_id";
$params = [':user_id' => $_SESSION['user_id']];

if (!empty($search)) {
    $whereClause .= " AND o.orden LIKE :search";
    $params[':search'] = "%$search%";
}

if (!empty($fecha_inicio)) {
    $whereClause .= " AND o.fecha >= :fecha_inicio";
    $params[':fecha_inicio'] = $fecha_inicio;
}

if (!empty($fecha_fin)) {
    $whereClause .= " AND o.fecha <= :fecha_fin";
    $params[':fecha_fin'] = $fecha_fin;
}

$query = "SELECT o.* FROM lab_m_orden o 
          JOIN fac_m_tarjetero t ON o.id_historia = t.id 
          $whereClause 
          ORDER BY o.fecha $orderBy 
          LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($query);

foreach ($params as $key => &$val) {
    $stmt->bindParam($key, $val);
}
$stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$ordenes = $stmt->fetchAll();

$totalQuery = "SELECT COUNT(*) FROM lab_m_orden o 
               JOIN fac_m_tarjetero t ON o.id_historia = t.id 
               $whereClause";

$totalStmt = $pdo->prepare($totalQuery);
$totalStmt->execute($params);
$totalOrdenes = $totalStmt->fetchColumn();
$totalPages = ceil($totalOrdenes / $perPage);
?>

<div class="particles-container" id="particles-js"></div>

<div class="container main-content">
    <h2 class="mt-5 text-center text-primary animate__animated animate__fadeIn">Mis Resultados de Laboratorio</h2>
    
    <div class="card welcome-card animate__animated animate__fadeInUp">
        <div class="card-body">
            <form class="mb-3">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por número de orden" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" class="form-control" name="fecha_inicio" value="<?php echo htmlspecialchars($fecha_inicio); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" class="form-control" name="fecha_fin" value="<?php echo htmlspecialchars($fecha_fin); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>
                                Fecha 
                                <a href="?order=<?php echo $orderBy == 'DESC' ? 'asc' : 'desc'; ?>&search=<?php echo urlencode($search); ?>&fecha_inicio=<?php echo urlencode($fecha_inicio); ?>&fecha_fin=<?php echo urlencode($fecha_fin); ?>" class="text-decoration-none">
                                    <i class="fas fa-sort<?php echo $orderBy == 'DESC' ? '-down' : '-up'; ?>"></i>
                                </a>
                            </th>
                            <th>Código del documento</th>
                            <th>Número de orden</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordenes as $orden): ?>
                            <tr class="animate__animated animate__fadeIn">
                                <td><?php echo htmlspecialchars($orden['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($orden['id_documento']); ?></td>
                                <td><?php echo htmlspecialchars($orden['orden']); ?></td>
                                <td>
                                    <a href="detalle_orden.php?id=<?php echo $orden['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye me-1"></i>Ver detalle
                                    </a>
                                    <button class="btn btn-sm btn-warning" onclick="printOrder(<?php echo $orden['id']; ?>)">
                                        <i class="fas fa-print me-1"></i>Imprimir
                                    </button>
                                    <button class="btn btn-sm btn-success" onclick="downloadOrder(<?php echo $orden['id']; ?>)">
                                        <i class="fas fa-download me-1"></i>Descargar detalles
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&order=<?php echo $orderBy; ?>&search=<?php echo urlencode($search); ?>&fecha_inicio=<?php echo urlencode($fecha_inicio); ?>&fecha_fin=<?php echo urlencode($fecha_fin); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script>
function printOrder(orderId) {
    // Implementar la función para imprimir detalles de la orden
    window.open('print_order.php?id=' + orderId, '_blank');
}

function downloadOrder(orderId) {
    // Implementar la función para descargar detalles de la orden
    window.location.href = 'download_order.php?id=' + orderId;
}

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
}

.welcome-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.table th, .table td {
    vertical-align: middle;
}
</style>
