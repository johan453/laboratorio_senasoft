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

// Modificada la consulta para obtener pacientes con su id_historia correspondiente
$stmt = $pdo->query("
    SELECT p.id, p.nombre1, p.apellido1, p.numero_identificacion, t.id as id_historia 
    FROM gen_m_persona p
    INNER JOIN fac_m_tarjetero t ON t.id_persona = p.id 
    ORDER BY p.apellido1, p.nombre1
");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch available tests for the dropdown
$stmt = $pdo->query("SELECT id, nombre FROM lab_p_pruebas ORDER BY nombre");
$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $patient_id = $data['patient_id'];
    $order_date = $data['order_date'];
    $selected_tests = $data['tests'] ?? [];

    try {
        $pdo->beginTransaction();

        // Verificar que el id_historia existe
        $checkStmt = $pdo->prepare("SELECT id FROM fac_m_tarjetero WHERE id = ?");
        $checkStmt->execute([$patient_id]);
        if (!$checkStmt->fetch()) {
            throw new PDOException("No existe el registro en fac_m_tarjetero");
        }

        // Get the latest order number
        $stmt = $pdo->query("SELECT MAX(CAST(orden AS UNSIGNED)) as max_order FROM lab_m_orden");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_order_number = $result['max_order'] ? $result['max_order'] + 1 : 1;

        // Insert the order with the new order number
        $stmt = $pdo->prepare("INSERT INTO lab_m_orden (id_historia, orden, fecha) VALUES (?, ?, ?)");
        $stmt->execute([$patient_id, $next_order_number, $order_date]);
        $order_id = $pdo->lastInsertId();

        // Insert the selected tests for this order
        $stmt = $pdo->prepare("INSERT INTO lab_m_orden_detalle (id_orden, id_prueba) VALUES (?, ?)");
        foreach ($selected_tests as $test_id) {
            $stmt->execute([$order_id, $test_id]);
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => "Orden agregada exitosamente con el número: " . $next_order_number, 'order_number' => $next_order_number]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => "Error al agregar la orden: " . $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Orden - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://unpkg.com/react@17/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
    <style>
        /* Los estilos permanecen igual */
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

        .test-checkbox {
            display: none;
        }

        .test-label {
            display: block;
            padding: 10px;
            margin: 5px 0;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .test-checkbox:checked + .test-label {
            background-color: var(--primary-color);
            color: white;
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
                        <a class="nav-link active" href="manage_orders.php">Gestionar Órdenes</a>
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
        <h1 class="mb-4 text-center animate__animated animate__fadeIn">Agregar Nueva Orden</h1>
        <div id="react-form"></div>
    </div>

    <script type="text/babel">
        const patients = <?php echo json_encode($patients); ?>;
        const tests = <?php echo json_encode($tests); ?>;

        function AddOrderForm() {
            const [selectedPatient, setSelectedPatient] = React.useState("");
            const [orderDate, setOrderDate] = React.useState("");
            const [selectedTests, setSelectedTests] = React.useState([]);
            const [success, setSuccess] = React.useState("");
            const [error, setError] = React.useState("");
            const [isLoading, setIsLoading] = React.useState(false);

            const handleSubmit = async (e) => {
                e.preventDefault();
                setError("");
                setSuccess("");
                setIsLoading(true);

                try {
                    const response = await fetch('', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            patient_id: selectedPatient,
                            order_date: orderDate,
                            tests: selectedTests,
                        }),
                    });

                    const data = await response.json();
                    if (data.success) {
                        setSuccess(data.message);
                        // Reset form
                        setSelectedPatient("");
                        setOrderDate("");
                        setSelectedTests([]);
                    } else {
                        throw new Error(data.message);
                    }
                } catch (err) {
                    setError(err.message);
                } finally {
                    setIsLoading(false);
                }
            };

            return (
                <div className="card animate__animated animate__fadeInUp">
                    <div className="card-body">
                        {error && <div className="alert alert-danger animate__animated animate__shakeX">{error}</div>}
                        {success && <div className="alert alert-success animate__animated animate__bounceIn">{success}</div>}
                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label htmlFor="patient" className="form-label">Paciente</label>
                                <select 
                                    className="form-select" 
                                    id="patient" 
                                    value={selectedPatient} 
                                    onChange={(e) => setSelectedPatient(e.target.value)}
                                    required
                                >
                                    <option value="">Seleccione un paciente...</option>
                                    {patients.map((patient) => (
                                        <option key={patient.id} value={patient.id_historia}>
                                            {`${patient.nombre1} ${patient.apellido1} (${patient.numero_identificacion})`}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div className="mb-3">
                                <label htmlFor="order_date" className="form-label">Fecha de Orden</label>
                                <input 
                                    type="date" 
                                    className="form-control" 
                                    id="order_date" 
                                    value={orderDate} 
                                    onChange={(e) => setOrderDate(e.target.value)}
                                    required
                                />
                            </div>
                            <div className="mb-3">
                                <label className="form-label">Pruebas</label>
                                <div className="row">
                                    {tests.map((test) => (
                                        <div key={test.id} className="col-md-4 mb-2">
                                            <input 
                                                type="checkbox"
                                                id={`test-${test.id}`}
                                                className="test-checkbox"
                                                checked={selectedTests.includes(test.id)}
                                                onChange={(e) => {
                                                    if (e.target.checked) {
                                                        setSelectedTests([...selectedTests, test.id]);
                                                    } else {
                                                        setSelectedTests(selectedTests.filter(id => id !== test.id));
                                                    }
                                                }}
                                            />
                                            <label className="test-label" htmlFor={`test-${test.id}`}>
                                                {test.nombre}
                                            </label>
                                        </div>
                                    ))}
                                </div>
                            </div>
                            <button type="submit" className="btn btn-primary w-100" disabled={isLoading}>
                                {isLoading ? (
                                    <span>
                                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        {' '}Agregando Orden...
                                    </span>
                                ) : (
                                    <span>
                                        <i className="fas fa-plus-circle"></i> Agregar Orden
                                    </span>
                                )}
                            </button>
                        </form>
                    </div>
                </div>
            );
        }

        ReactDOM.render(<AddOrderForm />, document.getElementById('react-form'));
    </script>

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
                },
                modes: {
                    grab: {
                        distance: 140,
                        line_linked: { opacity: 1 }
                    },
                    push: { particles_nb: 4 },
                }
            },
            retina_detect: true
        });
    </script>
</body>
</html>