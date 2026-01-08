<?php
// --- Guardar en: Privado/PrincipalCategorias/funcionesdetalle.php ---
require_once __DIR__ . '/../../conexion.php'; 

function subir_imagen_producto(array $file): ?string {
    if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    $permitidas = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $permitidas)) return null;
    $nombre = 'prod_' . uniqid() . '.' . $ext;
    $destino = __DIR__ . '/../../imagenes/' . $nombre; 
    if (!move_uploaded_file($file['tmp_name'], $destino)) return null;
    return $nombre;
}

function listar_categorias_dropdown(mysqli $conn): array {
    $sql = "SELECT id_categoria, nombre_categoria FROM categoria ORDER BY nombre_categoria ASC";
    $res = $conn->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

// --- FUNCIÓN ACTUALIZADA CON FILTRO ---
function listar_productos(mysqli $conn, $id_categoria = 0): array {
    $sql = "SELECT p.id_producto, p.nombre_producto, p.ImagenesProducto, c.nombre_categoria
            FROM productos p
            LEFT JOIN categoria c ON p.id_categoria = c.id_categoria";
    
    // Si se seleccionó una categoría, filtramos
    if ($id_categoria > 0) {
        $sql .= " WHERE p.id_categoria = " . (int)$id_categoria;
    }

    $sql .= " ORDER BY p.id_producto DESC";
    
    $res = $conn->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

function obtener_producto(mysqli $conn, int $id): ?array {
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $prod = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $prod ?: null;
}

function crear_producto(mysqli $conn, array $datos): bool {
    $sql = "INSERT INTO productos (id_categoria, nombre_producto, unidad_medida, calibre, metros, kg, color, ced, ton, cm, ImagenesProducto)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssddssdds", 
        $datos['id_categoria'], $datos['nombre_producto'], $datos['unidad_medida'], 
        $datos['calibre'], $datos['metros'], $datos['kg'], $datos['color'], 
        $datos['ced'], $datos['ton'], $datos['cm'], $datos['ImagenesProducto']
    );
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function actualizar_producto(mysqli $conn, int $id, array $datos, bool $conImagen): bool {
    if ($conImagen) {
        $sql = "UPDATE productos SET 
                    id_categoria=?, nombre_producto=?, unidad_medida=?, calibre=?, 
                    metros=?, kg=?, color=?, ced=?, ton=?, cm=?, ImagenesProducto=?
                    WHERE id_producto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssddssddsi", 
            $datos['id_categoria'], $datos['nombre_producto'], $datos['unidad_medida'], 
            $datos['calibre'], $datos['metros'], $datos['kg'], $datos['color'], 
            $datos['ced'], $datos['ton'], $datos['cm'], $datos['ImagenesProducto'],
            $id
        );
    } else {
        $sql = "UPDATE productos SET 
                    id_categoria=?, nombre_producto=?, unidad_medida=?, calibre=?, 
                    metros=?, kg=?, color=?, ced=?, ton=?, cm=?
                    WHERE id_producto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssddssddi", 
            $datos['id_categoria'], $datos['nombre_producto'], $datos['unidad_medida'], 
            $datos['calibre'], $datos['metros'], $datos['kg'], $datos['color'], 
            $datos['ced'], $datos['ton'], $datos['cm'],
            $id
        );
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function eliminar_producto(mysqli $conn, int $id): bool {
    $stmt = $conn->prepare("DELETE FROM productos WHERE id_producto=?");
    $stmt->bind_param("i", $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
?>