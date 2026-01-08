<?php
include 'funciones_empleados.php';
$lista = listar_empleados($conn);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Empleados</title>
  <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?php echo time(); ?>">
</head>

<body>

  <header>
    <section class="logo">
      <img src="ACASALogoAcerosA.png" alt="Logo de Aceros Alonso">
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
    <h1>Registro de empleados</h1>

 <?php if (!empty($_GET['ok'])): ?>
  <div class="notice">Operación exitosa.</div>
<?php endif; ?>

<?php if (!empty($_GET['err']) && $_GET['err'] === 'rel'): ?>
  <div class="notice notice--err">
    No se puede eliminar este empleado porque tiene registros relacionados.
  </div>
<?php endif; ?>

<?php if (!empty($_GET['err']) && $_GET['err'] !== 'rel'): ?>
  <div class="notice notice--err">Error al procesar.</div>
<?php endif; ?>





    <h2>Lista de empleados</h2>
    <div>
    <!-- ================================================ LLevar al formulario para crear uno nuevo ============================================== --> 
      <a href="formulario.php">
        <button class="btnAgregar" type="button" name="accion" value="crear" title="Añadir nuevo empleado">Agregar Empleado</button>
      </a>
 <!-- ============================================================================================== --> 
    </div>
    <br>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Departamento</th>
            <th>Puesto</th>
            <th>Usuario</th>
            <th>Acciones</th>
          </tr>
        </thead>
         <!-- ============================================================================================== --> 
        <tbody>
          <?php foreach ($lista as $r): ?>
            <tr>
              <td><?= (int)$r['Id_Empleado'] ?></td>
              <td><?= htmlspecialchars($r['Nombre'] . ' ' . $r['Apellido_Paterno']) ?></td>
              <td><?= htmlspecialchars($r['Correo']) ?></td>
              <td><?= htmlspecialchars($r['Telefono']) ?></td>
              <td><?= htmlspecialchars($r['Departamento']) ?></td>
              <td><?= htmlspecialchars($r['Puesto']) ?></td>
              <td><?= htmlspecialchars($r['Usuario']) ?></td>
              <td>
                <div class="row-actions">
                            <!-- ================================================ ENVIA AL FOMRULARIO EDITAR ENVIANDO EL ID============================================== --> 
                  <a href="editar.php?id=<?= (int)$r['Id_Empleado'] ?>" class="btn btn-edit">Editar</a>
                  <!-- ============================================================================================== --> 
                  
                  <form action="guardar_empleado.php" method="post" onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?')">
                    <input type="hidden" name="id_empleado" value="<?= (int)$r['Id_Empleado'] ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button class="btn btn-danger" type="submit">Borrar</button>
                  </form>
                </div>

              </td>
            </tr>
          <?php endforeach; ?>
           <!-- ============================================================================================== --> 
        </tbody>
      </table>
    </div>
  </main>

  <footer>
    <div class="footer-sections"></div>
    <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
  </footer>

</body>

</html>