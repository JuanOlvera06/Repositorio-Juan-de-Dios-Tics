<?php
include 'funciones_ubicaciones.php';

// Validar ID
if (!isset($_GET['id'])) {
    die("ID de ubicación no válido");
}

$datos = obtenerUbicacionPorId($conn, $_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Ubicación</title>
    <!-- <link rel="stylesheet" href="ubicaciones.css?v=<?php echo time(); ?>"> -->
    <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?php echo time(); ?>">
</head>

<body>

    <header>
        <section class="logo">
            <img src="../ACASALogoAcerosA.png" alt="Logo">
            <h2>Aceros Alonso</h2>
        </section>

        <nav>
            <ul>
                <li><a href="listar_ubicaciones.php">Volver</a></li>
            </ul>
        </nav>
    </header>
    <!--===========================COPIAR ESTO Y PEGAR EN LAS DEMAS PAGINAS================================== -->
    <script src="../Accesibilidad/accesi.js?v=<?php echo time(); ?>"></script>
    <!-- Botón de accesibilidad -->
    <div id="btnAccesibilidad" onclick="event.stopPropagation(); toggleMenuAccesibilidad()">
        <img src="../Accesibilidad/accesibilidad.png" style="width: 100%; height:100%; object-fit:cover;">
    </div>
    <!-- Iframe del menú -->
    <iframe
        id="menuAccesibilidad"
        src="../Accesibilidad/MenuAccesibilidad.html"
        class="accesibilidad-frame">
    </iframe>
    <!-- ===================================================================================================== -->
    <div class="container">

        <h1>Editar Ubicación</h1>

        <form action="procesar_editar.php" method="POST" class="formPregunta">

            <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">

            <!-- DESCRIPCIÓN -->
            <div class="form-section">
                <label>Descripción:</label>
                <textarea name="descripcion"><?php echo $datos['descripcion']; ?></textarea>
            </div>

            <!-- NUEVA IMAGEN -->
            <div class="form-section">
                <label>Imagen Nueva (opcional):</label>
                <input type="file" name="imagen">
            </div>

            <!-- PREVIEW IMAGEN -->
            <div class="form-section">
                <label>Imagen Actual:</label>
                <img src="images/<?php echo $datos['imagen_nombre']; ?>" alt="Imagen actual">
            </div>

            <!-- URL -->
            <div class="form-section">
                <label>URL Google Maps:</label>
                <input type="text" name="url" value="<?php echo $datos['url']; ?>">
            </div>
            <br>
            <!-- BOTÓN -->
            <div class="button-container">
                <button type="submit" class="btn btnGuardar">Actualizar</button>
                <a href="listar_ubicaciones.php" class="btn btn-neutral">Cancelar</a>
            </div>

        </form>

    </div>

    <footer>
        <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
    </footer>

</body>

</html>