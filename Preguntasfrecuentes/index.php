<?php
include 'funciones_faq.php';
$preguntas = obtenerPreguntas($conn);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Preguntas Frecuentes | Admin</title>
    <!-- <link rel="stylesheet" href="faq.css?v=<?php echo time(); ?>"> -->
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
<!--                 <li><a href="../../paginaPrincipal.php">Inicio</a></li> -->
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

        <h1>Preguntas Frecuentes</h1>


        <div>
            <a href="agregar_pregunta.php">
                <button class="btnAgregar" type="button">
                    Agregar Pregunta
                </button>
            </a>
        </div>

        <div class="container2">


            <div class="cards">
                <?php while ($fila = $preguntas->fetch_assoc()): ?>
                    <div class="card">
                        <h3><?php echo $fila['pregunta']; ?></h3>
                        <p><?php echo $fila['respuesta']; ?></p>

                        <div class="actions">
                            <a href="editar_pregunta.php?id=<?php echo $fila['id']; ?>"><button class="btn btn-edit" type="submit">Editar</button></a>
                            <a href="eliminar_pregunta.php?id=<?php echo $fila['id']; ?>" class="delete"><button class="btn btn-danger" type="submit">Eliminar</button></a>
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