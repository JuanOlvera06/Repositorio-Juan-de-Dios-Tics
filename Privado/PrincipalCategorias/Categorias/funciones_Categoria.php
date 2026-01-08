<?php
// --- Guardar en: Privado/PrincipalCategorias/funciones_Categoria.php ---
require_once __DIR__ . '/../../../conexion.php';

// 1. FUNCIÓN PARA LLENAR EL DROPDOWN (SELECT)
function listar_todas_las_categorias_simple(mysqli $conn): array {
    $sql = "SELECT id_categoria, nombre_categoria FROM categoria ORDER BY nombre_categoria ASC";
    $res = $conn->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

// 2. FUNCIÓN PRINCIPAL DE LA TABLA (CON FILTRO)
function listar_categorias_filtradas(mysqli $conn, $id_filtro = 0): array {
    // Consulta base
    $sql = "SELECT * FROM categoria";
    
    // Si el usuario seleccionó una opción en el select (ID > 0), filtramos
    if ($id_filtro > 0) {
        $sql .= " WHERE id_categoria = " . (int)$id_filtro;
    }

    $sql .= " ORDER BY id_categoria DESC";
    
    $res = $conn->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

// ... EL RESTO DE FUNCIONES (obtener, subir, crear, actualizar, eliminar) SIGUEN IGUAL ...
function obtener_categoria(mysqli $conn, int $id): ?array {
    $stmt = $conn->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $cat = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $cat ?: null;
}

function subir_imagen(array $file): ?string {
    if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    $permitidas = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $permitidas)) return null;
    $nombre = 'cat_' . uniqid() . '.' . $ext;
    $destino = __DIR__ . '/../../imagenes/' . $nombre; 
    if (!move_uploaded_file($file['tmp_name'], $destino)) return null;
    return $nombre;
}
    
function crear_categoria(mysqli $conn, string $nombre, ?string $texto, ?string $img): bool {
    $stmt = $conn->prepare("INSERT INTO categoria (nombre_categoria, texto_secundario, imagen_categoria) VALUES (?,?,?)");
    $stmt->bind_param("sss", $nombre, $texto, $img);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function actualizar_categoria(mysqli $conn, int $id, string $nombre, ?string $texto, ?string $imgNuevo): bool {
    if ($imgNuevo) {
        $stmt = $conn->prepare("UPDATE categoria SET nombre_categoria=?, texto_secundario=?, imagen_categoria=? WHERE id_categoria=?");
        $stmt->bind_param("sssi", $nombre, $texto, $imgNuevo, $id);
    } else {
        $stmt = $conn->prepare("UPDATE categoria SET nombre_categoria=?, texto_secundario=? WHERE id_categoria=?");
        $stmt->bind_param("ssi", $nombre, $texto, $id);
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function eliminar_categoria(mysqli $conn, int $id): bool {
    $stmt = $conn->prepare("DELETE FROM categoria WHERE id_categoria=?");
    $stmt->bind_param("i", $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
?>