<?php
session_start();

// Evitar cache del navegador
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirigir si ya hay sesión activa
if (isset($_SESSION['id_empleado'])) {
    header("Location: ../paginaPrincipal.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceros Alonso | Inicio de Sesión</title>
    <link rel="icon" href="../ACASALogoAcerosA.png" type="image/png" sizes="16px">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../StylesGeneralesPublic.css?v=<?php echo time(); ?>">

</head>
<body>
    <!-- Script para evitar que el login se muestre desde Back Forward Cache -->
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.replace('../paginaPrincipal.php');
            }
        });
    </script>

    <header>
        <section class="logo">
            <img src="../ACASALogoAcerosA.png" alt="Logo de Aceros Alonso">
            <h2>Aceros Alonso</h2>
        </section>
    </header>

    <main class="center-container">
        <section class="center-section">

            <div class="card-box">
                <h2>Iniciar Sesión</h2>

<?php if(isset($_SESSION['error'])): ?>
    <div class="notice notice--err">
        Contraseña o correo incorrectos.
    </div>
<?php 
    unset($_SESSION['error']); 
endif; ?>


                <form action="Validar.php" method="POST">
                    <input class="input-field" type="email" name="correo" placeholder="Correo" required
  pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.com$">
                    <input class="input-field" type="password" name="contrasena" placeholder="Contraseña" required>
                    <button class="btn-primary" type="submit">Entrar</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
    </footer>
</body>
</html>
