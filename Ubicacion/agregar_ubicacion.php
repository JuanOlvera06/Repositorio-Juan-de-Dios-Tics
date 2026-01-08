<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Ubicación</title>
    <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?php echo time();?>">
    <link rel="stylesheet" href="ubicaciones.css">
</head>
<body>

<header>
  <section class="logo">
    <img src="../ACASALogoAcerosA.png">
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
    <h1>Agregar Ubicación</h1>

    <form action="procesar_agregar.php" method="POST" class="formPregunta">
        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea>

        <label>Imagen:</label>
        <input type="file" name="imagen" required>

        <label>URL Google Maps:</label>
        <input type="text" name="url" required>

        <div class="button-container">
            <button type="submit">Guardar</button>
            <a href="listar_ubicaciones.php" class="btn btn-neutral">Cancelar</a>
        </div>
    </form>
</div>
<footer>
    <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
</footer>
</body>
</html>
