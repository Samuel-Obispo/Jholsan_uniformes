<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conexion = mysqli_connect('localhost', 'root', '', 'jholsan_uniformes');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['ISBN'];
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $precio = $_POST['precio'];
    $editorial = $_POST['editorial'];
    $imagen = $_POST['imagen'];

    if ($isbn === '') {
        $errores[] = 'Debes especificar un ISBN';
    }
    if ($nombre === '') {
        $errores[] = 'Debes especificar un Nombre';
    }
    if ($autor === '') {
        $errores[] = 'Debes especificar un Autor';
    }
    if ($precio === '') {
        $errores[] = 'Debes especificar un Precio';
    }
    if ($editorial === '') {
        $errores[] = 'Debes especificar una editorial';
    }
    if ($imagen === '') {
        $errores[] = 'Debes especificar una imagen';
    }

    if (empty($errores)) {
        $peticionInsertar = "INSERT INTO libros (isbn, nombre, autor, precio, editorial) VALUES ('$isbn', '$nombre', '$autor', '$precio', '$editorial')";

        if (mysqli_query($conexion, $peticionInsertar)) {
            echo 'Datos insertados correctamente';
        } else {
            if (mysqli_errno($conexion) == 1062) { // Código de error para entradas duplicadas
                header('Location: mensaje_error.php');
                exit();
            } else {
                echo "Error al insertar datos: " . mysqli_error($conexion);
            }
        }
    } else {
        header("Location: mensaje_error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear </title>
</head>
<body>
    <a href="index.php">Regresar</a>
    <a href="/ConectarBase/admin/List.php">Lista</a>
    <form action="" method="POST">
        <label for="">isbn</label>
        <input type="text" name="ISBN">
        <label for="">nombre</label>
        <input type="text" name="nombre">
        <label for="">autor</label>
        <input type="text" name="autor">
        <label for="">precio</label>
        <input type="number" name="precio">
        <label for="">editorial</label>
        <input type="text" name="editorial">
        <label for="">imagen</label>
        <input type="text" name="imagen">
        <input type="submit" value="subir">
    </form>
</body>
</html>