<?php
include '../conexion.php';

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pregunta = trim($_POST['pregunta']);
    $respuesta = trim($_POST['respuesta']);

    $sql = "INSERT INTO preguntas_frecuentes (pregunta, respuesta) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $pregunta, $respuesta);

    if ($stmt->execute()) {
        header("Location: index.php?msg=ok");
        exit();
    } else {
        echo "Error al guardar: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
