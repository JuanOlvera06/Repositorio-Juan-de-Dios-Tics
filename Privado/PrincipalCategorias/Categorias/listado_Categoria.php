<?php
// --- Guardar en: Privado/PrincipalCategorias/listado_categorias.php ---
require_once 'funciones_Categoria.php';

// Helpers
function h($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

// OBTENER EL FILTRO
$id_filtro = isset($_GET['filtro_id']) ? (int)$_GET['filtro_id'] : 0;

// CONSULTAS
//La lista para llenar el <select>
$categorias_para_select = listar_todas_las_categorias_simple($conn);

// La lista para llenar la <tabla> (filtrada o completa)
$lista_tabla = listar_categorias_filtradas($conn, $id_filtro);

$IMG_DIR_PUBLIC = '../../../imagenes/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin | Listado Categorías</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../StylesGenerales.css?v=<?php echo time(); ?>">
  
  <style>
    .alerta-admin { padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center; font-weight: bold; }
    .alerta-exito { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alerta-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

  .top-bar {
       /*display: flex; 
        justify-content: space-between; 
        align-items: center; */
        margin-bottom: 20px;
       /* flex-wrap: wrap; 
        gap: 15px;*/
    }

  /* .filtro-box {
        background-color: #f9f9f9; 
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }*/

    /*.thumb { max-height: 50px; object-fit: contain; }*/
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
        <li><a href="../../../../Consultas/consultas.php">Consultas</a></li>
      </ul>
    </nav>
  </header>

  <script src="../../../Accesibilidad/accesi.js?v=<?php echo time(); ?>"></script>
  <div id="btnAccesibilidad" onclick="event.stopPropagation(); toggleMenuAccesibilidad()">
      <img src="../../../Accesibilidad/accesibilidad.png" style="width: 100%; height:100%; object-fit:cover;">
  </div>
  <iframe id="menuAccesibilidad" src="../../../Accesibilidad/MenuAccesibilidad.html" class="accesibilidad-frame"></iframe>

  <main class="admin-detalle">
    
    <h1>Administrar Categorías</h1>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alerta-admin <?php echo ($_GET['mensaje']=='error') ? 'alerta-error' : 'alerta-exito'; ?>">
            <?php 
                $m = $_GET['mensaje'];
                if ($m == 'guardado') echo '¡Categoría creada correctamente!';
                elseif ($m == 'actualizado') echo '¡Categoría actualizada correctamente!';
                elseif ($m == 'eliminado') echo '¡Categoría eliminada correctamente!';
                else echo 'Ocurrió un error.';
            ?>
        </div>
    <?php endif; ?>

    <h2>Listado de Categorías</h2>
    
    <div class="top-bar">
        
        <a href="agregar_Categoria.php">
            <button class="btnAgregar">Agregar Categoría</button>
        </a>

       <!-- <div class="filtro-box">
          <!--   <label for="filtro">Filtrar por:</label>
        <!--     <form action="" method="GET" style="margin:0;">
        <!--         <select name="filtro_id" id="filtro" onchange="this.form.submit()" style="padding:5px;">
                    
        <!--             <option value="0">-- Todas las Categorías --</option>
                    
                    <?php foreach ($categorias_para_select as $cat): ?>
                        <option value="<?php echo $cat['id_categoria']; ?>" 
                            <?php if ($id_filtro == $cat['id_categoria']) echo 'selected'; ?>>
                            <?php echo h($cat['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </form>
        </div> -->

    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Texto Secundario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($lista_tabla)): ?>
            <?php foreach ($lista_tabla as $r): ?>
              <tr>
                <td><?php echo (int)$r['id_categoria']; ?></td>
                <td>
                  <?php if (!empty($r['imagen_categoria'])): ?>
                    <img class="thumb" src="<?php echo $IMG_DIR_PUBLIC . h($r['imagen_categoria']); ?>" alt="">
                  <?php else: ?>—<?php endif; ?>
                </td>
                <td><?php echo h($r['nombre_categoria']); ?></td>
                <td><?php echo h($r['texto_secundario']); ?></td>
                
                <td class="actions">
                  <a href="agregar_Categoria.php?id=<?php echo (int)$r['id_categoria']; ?>" class="btn btn-edit">
                    Editar
                  </a>
                  <form action="guardar_categoria.php" method="post" style="display:inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                    <input type="hidden" name="id_categoria" value="<?php echo (int)$r['id_categoria']; ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button class="btn btn-danger" type="submit">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No se encontraron resultados con ese filtro.</td>
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