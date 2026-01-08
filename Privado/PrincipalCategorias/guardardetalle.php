<?php
// --- Guardar en: Privado/PrincipalCategorias/guardardetalle.php ---
require_once __DIR__ . '/../../conexion.php';
include 'funcionesdetalle.php'; 

// Función para volver AL LISTADO con un mensaje
function volver($mensaje) {
    // Redirigimos a la página del listado
    $to = 'listadodetalle.php?mensaje=' . $mensaje;
    header('Location: ' . $to);
    exit;
}

$accion = $_POST['accion'] ?? '';

// Array de datos
$datos = [
    'id_categoria' => (int)($_POST['id_categoria'] ?? 0),
    'nombre_producto' => trim($_POST['nombre_producto'] ?? ''),
    'unidad_medida' => empty($_POST['unidad_medida']) ? null : trim($_POST['unidad_medida']),
    'calibre' => empty($_POST['calibre']) ? null : trim($_POST['calibre']),
    'metros' => empty($_POST['metros']) ? null : (float)$_POST['metros'],
    'kg' => empty($_POST['kg']) ? null : (float)$_POST['kg'],
    'color' => empty($_POST['color']) ? null : trim($_POST['color']),
    'ced' => empty($_POST['ced']) ? null : trim($_POST['ced']),
    'ton' => empty($_POST['ton']) ? null : (float)$_POST['ton'],
    'cm' => empty($_POST['cm']) ? null : (float)$_POST['cm'],
    'ImagenesProducto' => null 
];

if ($accion === 'crear') {
    if ($datos['nombre_producto'] === '' || $datos['id_categoria'] === 0) {
        header('Location: editardetalle.php?error=1'); // Si falla, vuelve al form
        exit;
    }
    
    $img = subir_imagen_producto($_FILES['ImagenesProducto'] ?? []);
    $datos['ImagenesProducto'] = $img;
    
    $ok = crear_producto($conn, $datos);
    
    // Redirigir al LISTADO con mensaje
    volver($ok ? 'guardado' : 'error');

} elseif ($accion === 'actualizar') {
    $id = (int)($_POST['id_producto'] ?? 0);
    $imagen_actual = trim($_POST['imagen_actual'] ?? '');
    
    if (!$id || $datos['nombre_producto'] === '' || $datos['id_categoria'] === 0) {
        header('Location: editardetalle.php?id='.$id.'&error=1'); 
        exit;
    }
    
    $imgNueva = subir_imagen_producto($_FILES['ImagenesProducto'] ?? []);
    $conImagenNueva = false;
    
    if ($imgNueva) {
        $datos['ImagenesProducto'] = $imgNueva;
        $conImagenNueva = true;
    } else {
        $datos['ImagenesProducto'] = $imagen_actual;
    }
    
    $ok = actualizar_producto($conn, $id, $datos, $conImagenNueva);
    
    // Redirigir al LISTADO con mensaje
    volver($ok ? 'actualizado' : 'error');

} elseif ($accion === 'eliminar') {
    $id = (int)($_POST['id_producto'] ?? 0);
    if (!$id) {
        header('Location: listadodetalle.php?error=1');
        exit;
    }
    $ok = eliminar_producto($conn, $id);
    
    // Redirigir al LISTADO con mensaje
    volver($ok ? 'eliminado' : 'error');

} else {
    header('Location: listadodetalle.php');
    exit;
}
?>