<?php
include '../conexion.php';

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pregunta = trim($_POST['pregunta']);
    $respuesta = trim($_POST['respuesta']);

    if ($pregunta == "" || $respuesta == "") {
        die("Error: campos vacíos.");
    }

    $sql = "INSERT INTO preguntas_frecuentes (pregunta, respuesta)
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $pregunta, $respuesta);

    if ($stmt->execute()) {
        header("Location: index.php?msg=ok");
        exit();
    } else {
        echo "Error al guardar: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Pregunta</title>
    <!-- <link rel="stylesheet" href="preguntas.css?v=<?php echo time();?>"> -->
     <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?php echo time(); ?>">
</head>
<body>

<header>
  <section class="logo">
    <img src="../ACASALogoAcerosA.png" alt="">
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
<div class="container">
    <h1>Agregar Pregunta</h1>

    <div class="card-form">
        <form action="guardar_pregunta.php" method="POST">

            <label for="pregunta">Pregunta:</label>
            <input type="text" name="pregunta" id="pregunta" required>

            <label for="respuesta">Respuesta:</label>
            <textarea name="respuesta" id="respuesta" required></textarea>

            <button type="submit" class="btn btnGuardar">Guardar</button>
            <a href="index.php" class="btn btn-neutral">Cancelar</a>
        </form>
    </div>
</div>


<footer>
    <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
</footer>
</body>
</html>
