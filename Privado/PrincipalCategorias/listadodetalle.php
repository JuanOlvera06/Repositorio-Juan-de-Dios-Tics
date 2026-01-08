<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/funcionesdetalle.php';

// Helpers
function h($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

// --- 1. OBTENER EL FILTRO DE CATEGORÍA ---
$filtro_categoria = isset($_GET['filtro_categoria']) ? (int)$_GET['filtro_categoria'] : 0;

// --- 2. CONSULTA FILTRADA ---
// Modificamos la llamada para pasar el filtro
$lista = listar_productos($conn, $filtro_categoria);
$categorias_lista = listar_categorias_dropdown($conn);

// Ruta pública de imágenes
$IMG_DIR_PUBLIC = '../../imagenes/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin | Productos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../StylesGenerales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styledetalle.css?v=<?php echo time(); ?>">
  
  <style>
    .alerta-admin {
        padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center; font-weight: bold;
    }
    .alerta-exito { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alerta-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    
    .filtro-box {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 5px;
        display: flex; align-items: center; gap: 10px;
    }
  </style>
</head>

<body>
  <header>
    <section class="logo">
      <img src="../../ACASALogoAcerosA.png" alt="Logo de Aceros Alonso">
      <h2>Aceros Alonso</h2>
    </section>
    <nav>
      <ul>
        <li><a href="../../Consultas/consultas.php">Consultas</a></li>
      </ul>
    </nav>
  </header>

  <script src="../../Accesibilidad/accesi.js?v=<?php echo time(); ?>"></script>
  <div id="btnAccesibilidad" onclick="event.stopPropagation(); toggleMenuAccesibilidad()">
      <img src="../../Accesibilidad/accesibilidad.png" style="width: 100%; height:100%; object-fit:cover;">
  </div>
  <iframe id="menuAccesibilidad" src="../../Accesibilidad/MenuAccesibilidad.html" class="accesibilidad-frame"></iframe>

  <main class="admin-detalle">
    
    <h1>Administrar Productos del Catálogo</h1>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alerta-admin <?php echo ($_GET['mensaje']=='error') ? 'alerta-error' : 'alerta-exito'; ?>">
            <?php 
                $m = $_GET['mensaje'];
                if ($m == 'guardado') echo '¡Producto registrado correctamente!';
                elseif ($m == 'actualizado') echo '¡Producto actualizado correctamente!';
                elseif ($m == 'eliminado') echo '¡Producto eliminado correctamente!';
                else echo 'Ocurrió un error.';
            ?>
        </div>
    <?php endif; ?>

    <h2>Listado de Productos</h2>
    
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;">
        
        <a href="editardetalle.php">
            <button class="btnAgregar">Agregar Producto</button>
        </a>

        <div class="filtro-box">
            <label for="filtro">Filtrar por:</label>
            <form action="" method="GET" style="margin:0;">
                <select name="filtro_categoria" id="filtro" onchange="this.form.submit()" style="padding:5px; margin:0;">
                    <option value="0">-- Todas las Categorías --</option>
                    <?php foreach ($categorias_lista as $cat): ?>
                        <option value="<?php echo $cat['id_categoria']; ?>" 
                            <?php if ($filtro_categoria == $cat['id_categoria']) echo 'selected'; ?>>
                            <?php echo h($cat['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
    </div>

    <br>
    
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($lista)): ?>
            <?php foreach ($lista as $r): ?>
              <tr>
                <td><?php echo (int)$r['id_producto']; ?></td>
                <td>
                  <?php if (!empty($r['ImagenesProducto'])): ?>
                    <img class="thumb" src="<?php echo $IMG_DIR_PUBLIC . h($r['ImagenesProducto']); ?>" alt="">
                  <?php else: ?>—<?php endif; ?>
                </td>
                <td><?php echo h($r['nombre_producto']); ?></td>
                <td><?php echo h($r['nombre_categoria']); ?></td>
                
                <td class="actions">
                  <a href="editardetalle.php?id=<?php echo (int)$r['id_producto']; ?>">
                    <button class="btn btn-edit">Editar</button>
                  </a>
                  
                  <form action="guardardetalle.php" method="post" style="display:inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                    <input type="hidden" name="id_producto" value="<?php echo (int)$r['id_producto']; ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button class="btn btn-danger" type="submit">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No hay productos registrados en esta categoría.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

  <footer>
    <div class="footer-sections">
      <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
    </div>
  </footer>

</body>
</html>