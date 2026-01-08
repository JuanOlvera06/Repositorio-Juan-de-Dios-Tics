<?php
include 'funciones_misionvision.php';

$mision = $_POST['mision'];
$vision = $_POST['vision'];
$info   = $_POST['info']; // nuevo campo

$dir = 'images/';

$img_mision = null;
$img_vision = null;
$iminfo = null;

// Subida de imágenes
if(!empty($_FILES['img_mision']['name'])) {
    $img_mision = $_FILES['img_mision']['name'];
    move_uploaded_file($_FILES['img_mision']['tmp_name'], $dir.$img_mision);
}

if(!empty($_FILES['img_vision']['name'])) {
    $img_vision = $_FILES['img_vision']['name'];
    move_uploaded_file($_FILES['img_vision']['tmp_name'], $dir.$img_vision);
}

if(!empty($_FILES['iminfo']['name'])) {
    $iminfo = $_FILES['iminfo']['name'];
    move_uploaded_file($_FILES['iminfo']['tmp_name'], $dir.$iminfo);
}

// Guardar en la BD
$actualizado = actualizarMisionVision($conn, $mision, $vision, $info, $img_mision, $img_vision, $iminfo);

if($actualizado){
    header("Location: editar_misionvision.php?exito=1");
    exit;
} else {
    echo "Error al actualizar: " . $conn->error;
}
?>

