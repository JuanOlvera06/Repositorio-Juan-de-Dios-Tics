<?php
// --- Guardar en: Privado/PrincipalCategorias/editar_Categoria.php ---
require_once __DIR__ . '/../../../conexion.php';
require_once 'funciones_Categoria.php';

function h($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

// Detectar si estamos editando (viene ID) o creando
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cat = $id ? obtener_categoria($conn, $id) : null;

// Rellenar variables (si es nuevo, van vacías)
$nombre = $cat['nombre_categoria'] ?? '';
$texto  = $cat['texto_secundario'] ?? '';
$img    = $cat['imagen_categoria'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin | <?php echo $id ? 'Editar' : 'Nueva'; ?> Categoría</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../StylesGenerales.css?v=<?php echo time(); ?>">
  <style>
      .form-actions { margin-top: 20px; }
      .thumb-preview { max-height: 100px; margin-top: 10px; display: block; }
  </style>
</head>

<body>
  <header>
    <section class="logo">
      <img src="../../../ACASALogoAcerosA.png" alt="Logo de Aceros Alonso">
      <h2>Aceros Alonso</h2>
    </section>
    <nav>
      <ul>      
        <li><a href="listado_Categoria.php">Volver al Listado</a></li>
      </ul>
    </nav>
  </header>

  <main class="admin-detalle">

    <h1><?php echo $id ? 'Editar Categoría' : 'Nueva Categoría'; ?></h1>
    
    <?php if (isset($_GET['error'])): ?>
      <div style="background:#f8d7da; color:#721c24; padding:10px; margin-bottom:15px; border-radius:5px;">
        Error: El nombre es obligatorio.
      </div>
    <?php endif; ?>

<div class="container2">
    <form action="guardar_categoria.php" method="post" enctype="multipart/form-data">
      
      <input type="hidden" name="id_categoria" value="<?php echo $id; ?>">
      <input type="hidden" name="accion" value="<?php echo $id ? 'actualizar' : 'crear'; ?>">

      <div class="row2">
        <div>
          <label>Nombre de la categoría </label>
          <input type="text" name="nombre_categoria" required value="<?php echo h($nombre); ?>" style="width:100%; padding:8px;">
        </div>
        <br>
        <div>
          <label>Texto secundario</label>
          <input type="text" name="texto_secundario" value="<?php echo h($texto); ?>" style="width:100%; padding:8px;">
        </div>
        <br>
        <div>
            <label>Imagen (jpg, png, webp)</label>
            <?php if ($img): ?>
                <div style="margin:5px 0;">
                    <p style="font-size:0.9em; color:#666;">Imagen actual:</p>
                    <img class="thumb-preview" src="../../imagenes/<?php echo h($img); ?>" alt="">
                   <img class="thumb-preview" src="../../../imagenes/<?php echo h($img); ?>" alt="">
                </div>
                <p style="font-size:0.8em;">Selecciona un archivo para cambiarla:</p>
            <?php endif; ?>
            <input type="file" name="imagen_categoria" accept=".jpg,.jpeg,.png,.webp">
        </div>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit"><?php echo $id ? 'Actualizar' : 'Guardar'; ?></button>
        <a href="listado_Categoria.php" class="btn btn-neutral">Cancelar</a>
      </div>

    </form>
    </div>


  </main>
  
  <footer>
    <div class="footer-sections">
      <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
    </div>
  </footer>
</body>
</html>