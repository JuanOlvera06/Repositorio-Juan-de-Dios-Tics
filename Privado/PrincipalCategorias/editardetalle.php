<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/funcionesdetalle.php';

// Helpers
function h($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
function param_get_int(string $key): int {
    $v = filter_input(INPUT_GET, $key, FILTER_VALIDATE_INT);
    return is_int($v) ? $v : 0;
}

//  OBTENER EL ID DEL PRODUCTO
$id = param_get_int('id');

// Si hay ID, cargamos el producto, si no, es un producto nuevo (array vacío)
$producto = [
    'id_producto' => 0,
    'id_categoria' => '',
    'nombre_producto' => '',
    'unidad_medida' => '',
    'calibre' => '',
    'metros' => '',
    'kg' => '',
    'color' => '',
    'ced' => '',
    'ton' => '',
    'cm' => '',
    'ImagenesProducto' => ''
];

if ($id > 0) {
    $encontrado = obtener_producto($conn, $id);
    if ($encontrado) {
        $producto = $encontrado;
    }
}

// OBTENER LA LISTA DE CATEGORÍAS
$categorias_lista = listar_categorias_dropdown($conn);

// LISTAS PARA LOS SELECTS
$lista_colores = ['N/A', 'Rojo', 'Negro', 'Verde', 'Azul', 'Blanco', 'Naranja', 'Amarillo', 'Gris', 'Galvanizado', 'Pintro', 'Zintro'];
$lista_unidades = ['Pieza', 'Kg', 'Metro', 'Tramo', 'Rollo', 'Lámina', 'Tonelada', 'Caja', 'Paquete', 'Juego'];
$lista_calibres = ['N/A', '10', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32', '40', '80'];

// Ruta publica de imágenes
$IMG_DIR_PUBLIC = '../../imagenes/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin | Editar Producto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../StylesGenerales.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styledetalle.css?v=<?php echo time(); ?>">
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

<main class="admin-detalle">
  
  <h1>Administrar Productos del Catálogo</h1>
  
  <form action="guardardetalle.php" method="POST" enctype="multipart/form-data">
    
    <input type="hidden" name="id_producto" value="<?php echo (int)$producto['id_producto']; ?>">
    <input type="hidden" name="accion" value="<?php echo ($producto['id_producto'] > 0) ? 'actualizar' : 'crear'; ?>">

    <h2>Información Principal</h2>
    <section class="container2">
    
    <div class="row">
        
        <label>
            Nombre del Producto *
            <input type="text" name="nombre_producto" value="<?php echo h($producto['nombre_producto']); ?>" required>
        </label>
        
        <label>
            Categoría *
            <select name="id_categoria" required>
                <option value="">Seleccione...</option>
                <?php foreach ($categorias_lista as $cat): ?>
                <option 
                    value="<?php echo (int)$cat['id_categoria']; ?>"
                    <?php if ($cat['id_categoria'] == $producto['id_categoria']) echo 'selected'; ?>
                >
                    <?php echo h($cat['nombre_categoria']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    
    <label>
        Imagen (jpg, png, webp) — si no eliges, se conserva la actual
        
        <?php if (!empty($producto['ImagenesProducto'])): ?>
            <div class="imagen-actual">
                <p style="margin: 5px 0 5px;">Imagen actual:</p>
                <img src="<?php echo $IMG_DIR_PUBLIC . h($producto['ImagenesProducto']); ?>" alt="Imagen actual" style="max-height: 100px;">
                <input type="hidden" name="imagen_actual" value="<?php echo h($producto['ImagenesProducto']); ?>">
            </div>
        <?php endif; ?>
        
        <input type="file" name="ImagenesProducto" accept="image/jpeg, image/png, image/webp">
    </label>

    <h2>Especificaciones Técnicas (Vista Detalle)</h2>
    
    <div class="row">
        
        <label>
            Unidad de Medida
            <select name="unidad_medida">
                <option value="">-- Seleccione --</option>
                <?php 
                    $unidadActual = h($producto['unidad_medida']);
                    foreach($lista_unidades as $opcion): 
                ?>
                    <option value="<?php echo $opcion; ?>" <?php if($unidadActual == $opcion) echo 'selected'; ?>>
                        <?php echo $opcion; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        
        <label>
            Calibre
            <select name="calibre">
                <option value="">-- N/A --</option>
                <?php 
                    $calibreActual = h($producto['calibre']);
                    foreach($lista_calibres as $opcion): 
                ?>
                    <option value="<?php echo $opcion; ?>" <?php if($calibreActual == $opcion) echo 'selected'; ?>>
                        <?php echo $opcion; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Metros (ej: 12.50)
            <input type="number" step="0.01" min="0" name="metros" value="<?php echo h($producto['metros']); ?>">
        </label>
        
        <label>
            Kg (ej: 158.75)
            <input type="number" step="0.01" min="0" name="kg" value="<?php echo h($producto['kg']); ?>">
        </label>
        
        <label>
            Color
            <select name="color">
                <option value="">-- N/A --</option>
                <?php 
                    $colorActual = h($producto['color']);
                    foreach($lista_colores as $opcion): 
                ?>
                    <option value="<?php echo $opcion; ?>" <?php if($colorActual == $opcion) echo 'selected'; ?>>
                        <?php echo $opcion; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        
        <label>
            Ced
            <input type="text" name="ced" value="<?php echo h($producto['ced']); ?>">
        </label>
        
        <label>
            Ton (ej: 1.5)
            <input type="number" step="0.01" min="0" name="ton" value="<?php echo h($producto['ton']); ?>">
        </label>
        
        <label>
            Cm (ej: 38.00)
            <input type="number" step="0.01" min="0" name="cm" value="<?php echo h($producto['cm']); ?>">
        </label>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="listadodetalle.php" class="btn btn-neutral">Cancelar</a>
    </div>
    </section>

  </form>
  
</main>

<footer>
  <div class="footer-sections">
    <p class="copy">Todos los derechos reservados © 2025 Aceros Alonso</p>
  </div>
</footer>

</body>
</html>