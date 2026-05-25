<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']) {
    header('Location: login.php');
    exit;
}

// ── CONEXIÓN ──────────────────────────────────────────
$host   = 'localhost';
$db     = 'trupernueve';
$user   = 'dev_user';
$pass   = 'Dev*2026';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('❌ Error de conexión: ' . $conn->connect_error);
}
$conn->set_charset('utf8');

$mensaje = '';
$tipo_msg = '';

// ── CREATE ────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {

    if ($_POST['accion'] === 'crear') {
        $nombre      = $conn->real_escape_string($_POST['nombre']);
        $categoria   = $conn->real_escape_string($_POST['categoria']);
        $marca       = $conn->real_escape_string($_POST['marca']);
        $precio      = (float) $_POST['precio'];
        $stock       = (int)   $_POST['stock'];
        $descripcion = $conn->real_escape_string($_POST['descripcion']);

        $sql = "INSERT INTO herramientas (nombre, categoria, marca, precio, stock, descripcion)
                VALUES ('$nombre','$categoria','$marca','$precio','$stock','$descripcion')";

        if ($conn->query($sql)) {
            $mensaje  = '✅ Herramienta agregada correctamente.';
            $tipo_msg = 'ok';
        } else {
            $mensaje  = '❌ Error al agregar: ' . $conn->error;
            $tipo_msg = 'err';
        }
    }

    // ── UPDATE ────────────────────────────────────────
    if ($_POST['accion'] === 'editar') {
        $id          = (int)   $_POST['id'];
        $nombre      = $conn->real_escape_string($_POST['nombre']);
        $categoria   = $conn->real_escape_string($_POST['categoria']);
        $marca       = $conn->real_escape_string($_POST['marca']);
        $precio      = (float) $_POST['precio'];
        $stock       = (int)   $_POST['stock'];
        $descripcion = $conn->real_escape_string($_POST['descripcion']);

        $sql = "UPDATE herramientas SET
                    nombre='$nombre', categoria='$categoria', marca='$marca',
                    precio='$precio', stock='$stock', descripcion='$descripcion'
                WHERE id=$id";

        if ($conn->query($sql)) {
            $mensaje  = '✅ Herramienta actualizada correctamente.';
            $tipo_msg = 'ok';
        } else {
            $mensaje  = '❌ Error al actualizar: ' . $conn->error;
            $tipo_msg = 'err';
        }
    }
}

// ── DELETE ────────────────────────────────────────────
if (isset($_GET['eliminar'])) {
    $id  = (int) $_GET['eliminar'];
    $sql = "DELETE FROM herramientas WHERE id=$id";
    if ($conn->query($sql)) {
        $mensaje  = '✅ Herramienta eliminada correctamente.';
        $tipo_msg = 'ok';
    } else {
        $mensaje  = '❌ Error al eliminar: ' . $conn->error;
        $tipo_msg = 'err';
    }
}

// ── OBTENER REGISTRO PARA EDITAR ──────────────────────
$editar = null;
if (isset($_GET['editar'])) {
    $id     = (int) $_GET['editar'];
    $res    = $conn->query("SELECT * FROM herramientas WHERE id=$id");
    $editar = $res->fetch_assoc();
}

// ── READ ──────────────────────────────────────────────
$herramientas = $conn->query("SELECT * FROM herramientas ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Panel Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f0f0;
            color: #222;
        }

        /* NAV */
        nav {
            background: #c0392b;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .nav-logo {
            font-size: 22px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 2px;
        }
        .nav-logo span { color: #f39c12; }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .nav-right span {
            color: #fff;
            font-size: 13px;
            opacity: 0.85;
        }
        .btn-salir {
            background: #a93226;
            color: #fff;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-salir:hover { background: #922b21; }

        /* CONTENIDO */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h2 {
            font-size: 24px;
            color: #c0392b;
            margin-bottom: 20px;
            border-left: 5px solid #c0392b;
            padding-left: 12px;
        }

        /* MENSAJE */
        .mensaje {
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 14px;
        }
        .mensaje.ok  { background: #eafaf1; color: #1e8449; border-left: 4px solid #1e8449; }
        .mensaje.err { background: #fdecea; color: #c0392b; border-left: 4px solid #c0392b; }

        /* FORMULARIO */
        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label {
            font-size: 12px;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px 14px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color: #c0392b; }

        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 12px;
        }
        .btn-primary {
            background: #c0392b;
            color: #fff;
            border: none;
            padding: 11px 28px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #a93226; }
        .btn-secondary {
            background: #eee;
            color: #555;
            border: none;
            padding: 11px 28px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-secondary:hover { background: #ddd; }

        /* TABLA */
        .table-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        thead {
            background: #c0392b;
            color: #fff;
        }
        thead th {
            padding: 13px 14px;
            text-align: left;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody tr { border-bottom: 1px solid #f0f0f0; transition: background 0.15s; }
        tbody tr:hover { background: #fef9f9; }
        tbody td { padding: 11px 14px; color: #333; }

        .badge {
            background: #fdecea;
            color: #c0392b;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
        }

        .btn-editar {
            background: #f39c12;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }
        .btn-editar:hover { background: #d68910; }

        .btn-eliminar {
            background: #c0392b;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
            margin-left: 6px;
        }
        .btn-eliminar:hover { background: #a93226; }

        .total-registros {
            padding: 12px 18px;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #f0f0f0;
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav>
    <div class="nav-logo">TRU<span>PER</span> <small style="font-size:13px;font-weight:400;opacity:0.8">Admin</small></div>
    <div class="nav-right">
        <span>👤 <?= htmlspecialchars($_SESSION['usuario']) ?></span>
        <a href="logout.php" class="btn-salir">Cerrar Sesión</a>
    </div>
</nav>

<div class="container">

    <!-- MENSAJE -->
    <?php if ($mensaje): ?>
        <div class="mensaje <?= $tipo_msg ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <!-- FORMULARIO CREAR / EDITAR -->
    <h2><?= $editar ? '✏️ Editar Herramienta' : '➕ Nueva Herramienta' ?></h2>

    <div class="form-card">
        <form method="POST" action="admin.php">
            <input type="hidden" name="accion" value="<?= $editar ? 'editar' : 'crear' ?>">
            <?php if ($editar): ?>
                <input type="hidden" name="id" value="<?= $editar['id'] ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" required
                        value="<?= htmlspecialchars($editar['nombre'] ?? '') ?>"
                        placeholder="Ej: Martillo 16 oz">
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <input type="text" name="categoria" required
                        value="<?= htmlspecialchars($editar['categoria'] ?? '') ?>"
                        placeholder="Ej: Percusión">
                </div>
                <div class="form-group">
                    <label>Marca</label>
                    <input type="text" name="marca" required
                        value="<?= htmlspecialchars($editar['marca'] ?? '') ?>"
                        placeholder="Ej: Truper">
                </div>
                <div class="form-group">
                    <label>Precio ($)</label>
                    <input type="number" name="precio" step="0.01" min="0" required
                        value="<?= htmlspecialchars($editar['precio'] ?? '') ?>"
                        placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" min="0" required
                        value="<?= htmlspecialchars($editar['stock'] ?? '') ?>"
                        placeholder="0">
                </div>
                <div class="form-group full">
                    <label>Descripción</label>
                    <input type="text" name="descripcion"
                        value="<?= htmlspecialchars($editar['descripcion'] ?? '') ?>"
                        placeholder="Descripción breve del producto">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <?= $editar ? '💾 Guardar Cambios' : '➕ Agregar Herramienta' ?>
                </button>
                <?php if ($editar): ?>
                    <a href="admin.php" class="btn-secondary">✖ Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- TABLA READ -->
    <h2>📋 Listado de Herramientas</h2>
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $herramientas->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['nombre']) ?></strong></td>
                    <td><span class="badge"><?= htmlspecialchars($row['categoria']) ?></span></td>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td>$<?= number_format($row['precio'], 2) ?></td>
                    <td><?= $row['stock'] ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td>
                        <a href="admin.php?editar=<?= $row['id'] ?>" class="btn-editar">✏️ Editar</a>
                        <a href="admin.php?eliminar=<?= $row['id'] ?>"
                           class="btn-eliminar"
                           onclick="return confirm('¿Seguro que deseas eliminar esta herramienta? Esta acción no se puede deshacer.')">
                           🗑️ Eliminar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="total-registros">
            Total de registros: <strong><?= $herramientas->num_rows === 0 ? $conn->query("SELECT COUNT(*) as t FROM herramientas")->fetch_assoc()['t'] : '' ?></strong>
            <?php
                $total = $conn->query("SELECT COUNT(*) as t FROM herramientas")->fetch_assoc()['t'];
                echo $total . ' herramientas registradas.';
            ?>
        </div>
    </div>

</div>

</body>
</html>
<?php $conn->close(); ?>
