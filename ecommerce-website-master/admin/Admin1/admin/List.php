<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conexion = mysqli_connect('localhost', 'root', '','libreria');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Eliminar registro si se envía una solicitud POST para eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    $sqlEliminar = "DELETE FROM libros WHERE id=$id";

    if (mysqli_query($conexion, $sqlEliminar)) {
        echo "Registro eliminado con éxito";
    } else {
        echo "Error eliminando el registro: " . mysqli_error($conexion);
    }
}

// Obtener todos los registros de la tabla libros
$sql = "SELECT * FROM libros";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Libros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        form {
            display: inline;
        }
        input[type="submit"] {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <h1>Editar producto</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>ISBN</th>
            <th>Nombre</th>
            <th>Autor</th>
            <th>Precio</th>
            <th>Editorial</th>
            <th>Acciones</th>
        </tr>
        <?php while ($libro = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo htmlspecialchars($libro['id']); ?></td>
                <td><?php echo htmlspecialchars($libro['isbn']); ?></td>
                <td><?php echo htmlspecialchars($libro['nombre']); ?></td>
                <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                <td><?php echo htmlspecialchars($libro['precio']); ?></td>
                <td><?php echo htmlspecialchars($libro['editorial']); ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($libro['id']); ?>">
                        <input type="submit" name="eliminar" value="Eliminar">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
mysqli_free_result($resultado);
mysqli_close($conexion);
?>
