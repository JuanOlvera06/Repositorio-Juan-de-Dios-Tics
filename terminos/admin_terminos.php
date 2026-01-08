<?php
require_once '../conexion.php';

$mensaje = "";
$tipo_mensaje = ""; // ok / error

// Valores para el formulario
$id_form = "";
$titulo_form = "";
$contenido_form = "";

// =========================
//   ACCIONES (POST)
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion    = $_POST['accion'] ?? '';
    $id        = trim($_POST['id'] ?? '');
    $titulo    = trim($_POST['titulo'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');

    if ($accion === 'guardar') {

        if ($titulo === '' || $contenido === '') {
            $mensaje = "El título y el contenido son obligatorios.";
            $tipo_mensaje = "error";

            // Devolver al formulario
            $id_form        = $id;
            $titulo_form    = $titulo;
            $contenido_form = $contenido;
        } else {
            if ($id === '' || $id == 0) {
                // INSERT
                $sql = "INSERT INTO terminos_condiciones (titulo, contenido) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $titulo, $contenido);
            } else {
                // UPDATE
                $sql = "UPDATE terminos_condiciones SET titulo = ?, contenido = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $titulo, $contenido, $id);
            }

            if ($stmt->execute()) {
                $mensaje = "Término guardado correctamente.";
                $tipo_mensaje = "ok";
                // Limpiar formulario
                $id_form = $titulo_form = $contenido_form = "";
            } else {
                $mensaje = "Error al guardar: " . $conn->error;
                $tipo_mensaje = "error";
                $id_form        = $id;
                $titulo_form    = $titulo;
                $contenido_form = $contenido;
            }
            $stmt->close();
        }
    }

    if ($accion === 'eliminar') {
        if ($id === '' || $id == 0) {
            $mensaje = "No se recibió el ID del término a eliminar.";
            $tipo_mensaje = "error";
        } else {
            $sql = "DELETE FROM terminos_condiciones WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $mensaje = "Término eliminado correctamente.";
                $tipo_mensaje = "ok";
            } else {
                $mensaje = "Error al eliminar: " . $conn->error;
                $tipo_mensaje = "error";
            }
            $stmt->close();
        }
    }
}

// =========================
//   MODO EDICIÓN (GET)
// =========================
$modo      = $_GET['modo'] ?? '';
$id_editar = $_GET['id'] ?? '';

if ($modo === 'editar' && $id_editar !== '') {
    $sql = "SELECT * FROM terminos_condiciones WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($fila = $res->fetch_assoc()) {
        $id_form        = $fila['id'];
        $titulo_form    = $fila['titulo'];
        $contenido_form = $fila['contenido'];
    }
    $stmt->close();
}

// =========================
//   LISTA DE TÉRMINOS
// =========================
$sqlLista = "SELECT * FROM terminos_condiciones ORDER BY id ASC";
$lista = $conn->query($sqlLista);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administrar Términos y Condiciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?php echo time() ?>">
</head>

<body>
    <header>
        <section class="logo">
            <img src="../ACASALogoAcerosA.png" alt="Logo de Aceros Alonso">
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

        <div class="container">

            <h1>Lista de Términos y Condiciones</h1>
            <p>Aquí puedes ver todos los términos registrados, editarlos o eliminarlos.</p>

            <?php if ($mensaje !== ""): ?>
                <?php if ($tipo_mensaje === 'ok'): ?>
                    <div class="success-message">
                        <?= htmlspecialchars($mensaje); ?>
                    </div>
                <?php else: ?>
                    <div class="notice notice--err">
                        <?= htmlspecialchars($mensaje); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th style="width:140px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista && $lista->num_rows > 0): ?>
                            <?php $i = 1; ?>
                            <?php while ($row = $lista->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($row['titulo']); ?></td>
                                    <td>
                                        <div class="row-actions">
                                            <a class="btn btn-edit"
                                                href="admin_terminos.php?modo=editar&id=<?= $row['id']; ?>">
                                                Editar
                                            </a>

                                            <form action="admin_terminos.php" method="post"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este término?');">
                                                <input type="hidden" name="accion" value="eliminar">
                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No hay términos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BLOQUE: FORMULARIO AGREGAR / EDITAR -->
        <div class="container">
            <h1><?= $id_form === "" ? "Agregar nuevo término" : "Editar término"; ?></h1>
            <p>Completa el formulario para agregar un nuevo término o actualizar uno existente.</p>

            <form action="admin_terminos.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id_form); ?>">
                <input type="hidden" name="accion" value="guardar">

                <label for="titulo">
                    Título
                    <input type="text" id="titulo" name="titulo"
                        value="<?= htmlspecialchars($titulo_form); ?>">
                </label>

                <label for="contenido">
                    Contenido
                    <textarea id="contenido" name="contenido"><?= htmlspecialchars($contenido_form); ?></textarea>
                </label>

                <div class="button-container" style="text-align:left;">
                    <a href="../Catalogo/CatalogoCategorias.php" class="btn btn-neutral">Cancelar</a>
                    <button type="submit" class="btnGuardar">Guardar cambios</button>
                </div>
            </form>
        </div>

    </main>
    <footer>
        <div class="footer-sections">
        </div>
        <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
    </footer>

</body>

</html>