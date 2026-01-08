<?php
include 'funciones_empleados.php';

// Cargamos listas para los select
$departamentos = obtener_departamentos($conn);
$puestos = obtener_puestos($conn);
$usuarios = obtener_tipos_usuario($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Empleado</title>
  <link rel="stylesheet" href="empleados.css?=<?= time() ?>">
  <link rel="stylesheet" href="../Privado/StylesGenerales.css?v=<?= time() ?>">
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

<main class="admin-detalle">
  <h1>Registro de empleados</h1>
<section class="container2">
  <form action="guardar_empleado.php" method="post">

    <div class="form-grid">
      <label for="nombre">Nombre
        <input id="nombre" type="text" name="nombre" required pattern=".{1,}" title="El nombre no puede ir vacío">
      </label>

      <label for="apaterno">Apellido Paterno
        <input id="apaterno" type="text" name="apaterno" required pattern=".{1,}" title="El apellido paterno no puede ir vacío">
      </label>

      <label for="amaterno">Apellido Materno
        <input id="amaterno" type="text" name="amaterno" required pattern=".{1,}" title="El apellido materno no puede ir vacío">
      </label>

<label for="correo">Correo
  <input id="correo" type="email" name="correo" required
  pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.com$"
         title="Ingrese un correo válido con formato: ejemplo@dominio.com">
</label>

      <label for="telefono">Teléfono
        <input id="telefono" type="text" name="telefono" required
               pattern="^[0-9]{10}$"
               title="El teléfono debe tener exactamente 10 dígitos numéricos">
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
            <option value="<?= (int)$d['Id_Departamento'] ?>"><?= $d['Departamento'] ?></option>
          <?php endforeach; ?>
        </select>
      </label>

      <label for="puesto">Puesto
        <select id="puesto" name="puesto" required>
          <option value="">-- Selecciona --</option>
          <?php foreach ($puestos as $p): ?>
            <option value="<?= (int)$p['Id_Puesto'] ?>"><?= $p['Puesto'] ?></option>
          <?php endforeach; ?>
        </select>
      </label>

      <label for="tipo_usuario">Tipo de usuario
        <select id="tipo_usuario" name="tipo_usuario" required>
          <option value="">-- Selecciona --</option>
          <?php foreach ($usuarios as $u): ?>
            <option value="<?= (int)$u['Id_Tipo_Usuario'] ?>"><?= $u['Usuario'] ?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>

    <div class="actions-bar">
      <button class="btn btn-primary" type="submit" name="accion" value="crear">Guardar</button>
      <a href="empleados.php" class="btn btn-neutral">Cancelar</a>
    </div>
  </form>
  </section>
    <br><br><br>


</main>

<footer>
  <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
</footer>

</body>
</html>

