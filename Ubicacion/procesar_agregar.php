<?php
include 'funciones_ubicaciones.php';

$descripcion = $_POST['descripcion'];
$url = $_POST['url'];

$dir = "images/";
$imagen = $_FILES['imagen']['name'];

move_uploaded_file($_FILES['imagen']['tmp_name'], $dir.$imagen);

insertarUbicacion($conn, $descripcion, $imagen, $url);

header("Location: listar_ubicaciones.php");
exit;
?>
