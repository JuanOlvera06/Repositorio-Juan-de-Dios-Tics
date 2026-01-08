
<?php
include 'funciones_empleados.php';

// Si hay un ID, cargamos los datos de ese empleado
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$emp = $id ? obtener_empleado($conn, $id) : null;

// Cargamos listas para los select
$departamentos = obtener_departamentos($conn);
$puestos = obtener_puestos($conn);
$usuarios = obtener_tipos_usuario($conn);
$lista = listar_empleados($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Empleados</title>
  <link rel="stylesheet" href="empleados.css?=<?= time() ?>">
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
     <!-- <li><a href="../paginaPrincipal.php">Inicio</a></li>-->
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
  <?php if (!empty($_GET['err'])): ?>
    <div class="notice notice--err">Error al procesar.</div>
  <?php endif; ?>

<section class="container2">
<form action="guardar_empleado.php" method="post">
  <input type="hidden" name="id_empleado" value="<?= $emp['Id_Empleado'] ?? 0 ?>">

  <div class="form-grid">
    <label for="nombre">Nombre
      <input id="nombre" type="text" name="nombre" required
             pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}"
             title="Solo letras y espacios, entre 2 y 50 caracteres"
             value="<?= $emp['Nombre'] ?? '' ?>">
    </label>

    <label for="apaterno">Apellido Paterno
      <input id="apaterno" type="text" name="apaterno" required
             pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}"
             title="Solo letras y espacios, entre 2 y 50 caracteres"
             value="<?=$emp['Apellido_Paterno'] ?? '' ?>">
    </label>

    <label for="amaterno">Apellido Materno
      <input id="amaterno" type="text" name="amaterno" required
             pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}"
             title="Solo letras y espacios, entre 2 y 50 caracteres"
             value="<?= htmlspecialchars($emp['Apellido_Materno'] ?? '') ?>">
    </label>

<label for="correo">Correo
  <input id="correo" type="email" name="correo" required
         title="Ingrese un correo válido con formato: ejemplo@dominio.com"
         value="<?= htmlspecialchars($emp['Correo'] ?? '') ?>">
</label>



    <label for="telefono">Teléfono
      <input id="telefono" type="tel" name="telefono" required
             pattern="\d{10}"
             title="Ingrese un número de 10 dígitos"
             value="<?= htmlspecialchars($emp['Telefono'] ?? '') ?>">
    </label>


      <label for="contrasena">Contraseña
        <input id="contrasena" type="password" name="contrasena" required
               pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*#).{8,}"
               title="La contraseña debe tener mínimo 8 caracteres, al menos 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial (#)">
      </label>

    <label for="departamento">Departamento
      <select id="departamento" name="departamento" required>
        <option value="">-- Selecciona --</option>
        <?php foreach ($departamentos as $d): ?>
          <option value="<?= (int)$d['Id_Departamento'] ?>"
            <?= ($emp && (int)$emp['Id_Departamento'] === (int)$d['Id_Departamento']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($d['Departamento']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <label for="puesto">Puesto
      <select id="puesto" name="puesto" required>
        <option value="">-- Selecciona --</option>
        <?php foreach ($puestos as $p): ?>
          <option value="<?= (int)$p['Id_Puesto'] ?>"
            <?= ($emp && (int)$emp['Id_Puesto'] === (int)$p['Id_Puesto']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['Puesto']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <label for="tipo_usuario">Tipo de usuario
      <select id="tipo_usuario" name="tipo_usuario" required>
        <option value="">-- Selecciona --</option>
        <?php foreach ($usuarios as $u): ?>
          <option value="<?= (int)$u['Id_Tipo_Usuario'] ?>"
            <?= ($emp && (int)$emp['Id_Tipo_Usuario'] === (int)$u['Id_Tipo_Usuario']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($u['Usuario']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>

  <div class="actions-bar">
    <button class="btn btn-primary" type="submit" name="accion" value="actualizar">Actualizar</button>
    <a href="empleados.php" class="btn btn-neutral">Cancelar</a>
  </div>
</form>
</section>

<br><br><br>
</main>


<footer>
  <div class="footer-sections"></div>
  <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
</footer>

</body>
</html>