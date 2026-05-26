<?php ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Herramientas Profesionales</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        /* NAV */
        nav {
            background: #c0392b;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 40px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .logo {
            font-size: 28px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 2px;
        }
        .logo span { color: #f39c12; }
        nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
        }
        nav ul a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: color 0.2s;
        }
        nav ul a:hover { color: #f39c12; }

        /* HERO */
        #inicio {
            background: linear-gradient(135deg, #c0392b 60%, #e74c3c);
            color: white;
            padding: 100px 40px;
            text-align: center;
        }
        #inicio h1 {
            font-size: 52px;
            font-weight: 900;
            margin-bottom: 20px;
        }
        #inicio p {
            font-size: 20px;
            margin-bottom: 35px;
            opacity: 0.9;
        }
        .btn-hero {
            background: #f39c12;
            color: #fff;
            padding: 14px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: background 0.2s;
        }
        .btn-hero:hover { background: #d68910; }

        /* SECCIONES */
        section { padding: 70px 40px; }
        section h2 {
            font-size: 34px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 40px;
            color: #c0392b;
        }

        /* PRODUCTOS */
        #productos { background: #fff; }
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }
        .producto-card {
            background: #f9f9f9;
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 28px 20px;
            text-align: center;
            transition: transform 0.2s, border-color 0.2s;
        }
        .producto-card:hover {
            transform: translateY(-6px);
            border-color: #c0392b;
        }
        .producto-card .icono { font-size: 48px; margin-bottom: 14px; }
        .producto-card h3 { font-size: 18px; color: #222; margin-bottom: 8px; }
        .producto-card p  { font-size: 14px; color: #777; }

        /* MISIÓN / VISIÓN */
        #misionvision { background: #f0f0f0; }
        .mv-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            max-width: 900px;
            margin: 0 auto;
        }
        .mv-card {
            background: #fff;
            border-left: 6px solid #c0392b;
            border-radius: 10px;
            padding: 30px;
        }
        .mv-card h3 {
            font-size: 22px;
            color: #c0392b;
            margin-bottom: 12px;
        }
        .mv-card p { color: #555; line-height: 1.7; }

        /* FOOTER */
        footer {
            background: #1a1a1a;
            color: #aaa;
            text-align: center;
            padding: 30px 20px;
            font-size: 14px;
        }
        footer span { color: #c0392b; font-weight: 700; }

        .btn-admin {
            display: inline-block;
            margin-top: 16px;
            background: #c0392b;
            color: #fff;
            padding: 10px 28px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-admin:hover { background: #a93226; }
    </style>
</head>
<body>

<!-- NAV -->
<nav>
    <div class="logo">TRU<span>PER</span></div>
    <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#productos">Productos</a></li>
        <li><a href="#misionvision">Misión/Visión</a></li>
        <li><a href="login.php">Administración</a></li>
    </ul>
</nav>

<!-- INICIO -->
<section id="inicio">
    <h1>🔧 Herramientas que trabajan contigo</h1>
    <p>Calidad profesional para cada proyecto. Desde el taller hasta la obra.</p>
    <a href="#productos" class="btn-hero">Ver Productos</a>
</section>

<!-- PRODUCTOS -->
<section id="productos">
    <h2>Nuestras Categorías</h2>
    <div class="productos-grid">
        <div class="producto-card">
            <div class="icono">🔨</div>
            <h3>Percusión</h3>
            <p>Martillos, mazos, cinceles y punterías para todo tipo de trabajo.</p>
        </div>
        <div class="producto-card">
            <div class="icono">🔩</div>
            <h3>Llaves</h3>
            <p>Llaves ajustables, españolas, Allen y de tubo de alta resistencia.</p>
        </div>
        <div class="producto-card">
            <div class="icono">📏</div>
            <h3>Medición</h3>
            <p>Cintas métricas, niveles, escuadras y plomadas de precisión.</p>
        </div>
        <div class="producto-card">
            <div class="icono">⚡</div>
            <h3>Eléctrico</h3>
            <p>Taladros, esmeriladores, sierras y pistolas de calor profesionales.</p>
        </div>
        <div class="producto-card">
            <div class="icono">✂️</div>
            <h3>Corte</h3>
            <p>Seguetas, navajas, serruchos y arcos para cortes precisos.</p>
        </div>
        <div class="producto-card">
            <div class="icono">🗜️</div>
            <h3>Sujeción</h3>
            <p>Mordazas, prensas y abrazaderas para asegurar tu trabajo.</p>
        </div>
    </div>
</section>

<!-- MISIÓN / VISIÓN -->
<section id="misionvision">
    <h2>Misión y Visión</h2>
    <div class="mv-grid">
        <div class="mv-card">
            <h3>🎯 Misión</h3>
            <p>Proveer herramientas de alta calidad y durabilidad que impulsen
            la productividad de profesionales y aficionados, ofreciendo
            soluciones confiables para cada necesidad de trabajo en México
            y el mundo.</p>
        </div>
        <div class="mv-card">
            <h3>🚀 Visión</h3>
            <p>Ser la marca de herramientas más confiable y reconocida de
            América Latina, innovando constantemente en diseño y tecnología
            para superar las expectativas de nuestros clientes y distribuidores.</p>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p>&copy; 2026 <span>TRUPER</span> — Herramientas Profesionales. Todos los derechos reservados.</p>
    <a href="login.php" class="btn-admin">Acceso Administración</a>
</footer>
<p>&copy; 2026 <span>TRUPER</span> – Herramientas Profesionales. Desplegado en VPS - Equipo 9.</p>

</body>
</html>
<-- Crear usuario 'dev_user' con contraseña Despliegue v2 - prueba git pull -->
<-- Crear usuario 'dev_user' con contraseña Cambio en vivo - defensa Tue May 26 04:29:20 PM UTC 2026 -->
