<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario_correcto  = '22161099@gmail.com';
    $password_correcta = '12345';

    if ($usuario === $usuario_correcto && $password === $password_correcta) {
        $_SESSION['autenticado'] = true;
        $_SESSION['usuario']     = $usuario;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Iniciar Sesión</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #c0392b, #1a1a1a);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo h1 {
            font-size: 38px;
            font-weight: 900;
            color: #c0392b;
            letter-spacing: 3px;
        }

        .logo p {
            color: #888;
            font-size: 13px;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 14px;
            color: #222;
            transition: border-color 0.2s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #c0392b;
        }

        .btn-login {
            width: 100%;
            background: #c0392b;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 8px;
        }

        .btn-login:hover { background: #a93226; }

        .error {
            background: #fdecea;
            border-left: 4px solid #c0392b;
            color: #c0392b;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #c0392b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .back-link a:hover { text-decoration: underline; }

        .icono-lock {
            text-align: center;
            font-size: 40px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

<div class="login-box">

    <div class="logo">
        <div class="icono-lock">🔐</div>
        <h1>TRUPER</h1>
        <p>Panel de Administración</p>
    </div>

    <?php if ($error): ?>
        <div class="error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">

        <div class="form-group">
            <label for="usuario">Correo institucional</label>
            <input
                type="text"
                id="usuario"
                name="usuario"
                placeholder="tunumcontrol@itoaxaca.edu.mx"
                value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••••••"
                required
            >
        </div>

        <button type="submit" class="btn-login">Iniciar Sesión</button>

    </form>

    <div class="back-link">
        <a href="index.php">← Volver al sitio</a>
    </div>

</div>

</body>
</html>
