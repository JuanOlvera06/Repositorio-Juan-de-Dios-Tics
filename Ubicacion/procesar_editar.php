<?php
include 'funciones_ubicaciones.php';

$id = $_POST['id'];
$descripcion = $_POST['descripcion'];
$url = $_POST['url'];

$imagen = null;

if (!empty($_FILES['imagen']['name'])) {
    $imagen = $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "images/".$imagen);
}

actualizarUbicacion($conn, $id, $descripcion, $imagen, $url);

header("Location: listar_ubicaciones.php");
exit;
?>
