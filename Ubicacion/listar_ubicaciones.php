<?php
include 'funciones_ubicaciones.php';
$ubicaciones = obtenerUbicaciones($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ubicaciones | Admin</title>
    <!-- <link rel="stylesheet" href="ubicaciones.css?v=<?php echo time(); ?>"> -->
    <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?php echo time();?>">
</head>
<body>

<header>
  <section class="logo">
    <img src="../ACASALogoAcerosA.png" alt="Logo">
    <h2>Aceros Alonso</h2>
  </section>
  <nav>
    <ul>
      <li><a href="../Consultas/consultas.php">Consultas</a></li>
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
<main class="admin-detalle">

    <h1>Ubicaciones</h1>

    <h2>Nuestras sucursales</h2>

    <div>
        <a href="agregar_ubicacion.php">
            <button class="btnAgregar" type="button">
                Agregar ubicacion
            </button>
        </a>
    </div>

<div class="container2">
    <div class="cards">
    <?php while ($fila = $ubicaciones->fetch_assoc()): ?>
        <div class="card">
            <img src="images/<?php echo $fila['imagen_nombre']; ?>" alt="">
            <h3><?php echo $fila['descripcion']; ?></h3>
            <p><a href="<?php echo $fila['url']; ?>" target="_blank">Ver en Google Maps</a></p>

            <div class="actions">
                <a href="editar_ubicacion.php?id=<?php echo $fila['id']; ?>"><button class="btn btn-edit" type="submit" name="accion" value="eliminar">Editar</button></a>
                <a href="eliminar_ubicacion.php?id=<?php echo $fila['id']; ?>" class="delete"><button class="btn btn-danger" type="submit" name="accion" value="eliminar">Eliminar</button></a>
                
            </div>
        </div>
    <?php endwhile; ?>
    </div>

</div>
</main>

<footer>
    <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
</footer>

</body>
</html>
