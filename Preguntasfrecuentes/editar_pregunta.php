<?php
include 'funciones_faq.php';
$datos = obtenerPreguntaPorId($conn, $_GET['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Pregunta</title>
    <!-- <link rel="stylesheet" href="faq.css?v=<?php echo time();?>"> -->
     <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?php echo time();?>">
</head>
<body>

<header>
  <section class="logo">
    <img src="../ACASALogoAcerosA.png">
    <h2>Aceros Alonso</h2>
  </section>
  <nav>
    <ul>
      <li><a href="index.php">Volver</a></li>
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
    <h1>Editar Pregunta</h1>

    <form action="procesar_editar.php" method="POST" class="formPregunta">
        <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">

        <label>Pregunta:</label>
        <input type="text" name="pregunta" value="<?php echo $datos['pregunta']; ?>" required>

        <label>Respuesta:</label>
        <textarea name="respuesta" required><?php echo $datos['respuesta']; ?></textarea>

        <div class="button-container">
            <button type="submit" class="btnGuardar">Actualizar</button>
            <a href="index.php" class="btn btn-neutral">Cancelar</a>
        </div>
    </form>
</div>
<footer>
    <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
</footer>

</body>
</html>
