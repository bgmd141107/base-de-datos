<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta DB</title>
    <style type="text/css">
        /* Estilo general del cuerpo */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('abstract-1780176_1280.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            flex-direction: column;
        }

        /* Estilo del campo de búsqueda */
        #searchInput {
            margin-bottom: 20px;
            padding: 10px;
            width: 40%;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Estilo de la tabla */
        table {
            width: 80%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        /* Estilo de los encabezados */
        th {
            background-color: #6200ea;
            color: white;
            padding: 12px 15px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 14px;
        }

        /* Estilo de las celdas */
        td {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        /* Estilo para la fila de la cabecera */
        tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* Estilo del botón */
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #6200ea;
            border: none;
            border-radius: 20px;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #3700b3;
        }
    </style>
</head>
<body>

    <!-- Campo de búsqueda encima de la tabla -->
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Buscar por nombre o usuario">

    <?php
    // Habilitar la visualización de errores
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Configuración del servidor y la base de datos
    $user = "root";
    $pass = "";
    $host = "localhost";
    $datab = "dbformulario";
    $connection = mysqli_connect($host, $user, $pass, $datab);

    if (!$connection) {
        die("No se ha podido conectar con el servidor: " . mysqli_connect_error());
    }

    // Comprobar si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];

        // Preparar la consulta de inserción
        $sql = "INSERT INTO tabla_form (nombre, usuario) VALUES ('$nombre', '$usuario')";
        if (mysqli_query($connection, $sql)) {
        } else {
            echo "Error: " . mysqli_error($connection) . "<br>";
        }
    }

    // Consultar la base de datos
    $consulta = "SELECT * FROM tabla_form";
    $result = mysqli_query($connection, $consulta);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($connection));
    }

    // Mostrar la tabla
    echo "<table id='dataTable'>";
    echo "<tr><th>Id</th><th>Nombre</th><th>Usuario</th></tr>";
    while ($colum = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $colum['id'] . "</td>";
        echo "<td>" . $colum['nombre'] . "</td>";
        echo "<td>" . $colum['usuario'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Cerrar la conexión
    mysqli_close($connection);
    ?>

    <a href="index.html" class="button">Volver Atrás</a>

    <script>
        function searchTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("dataTable");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                var tdArray = tr[i].getElementsByTagName("td");
                var rowContainsFilter = false;

                for (var j = 0; j < tdArray.length; j++) {
                    var td = tdArray[j];
                    if (td) {
                        var textValue = td.textContent || td.innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            rowContainsFilter = true;
                            break;
                        }
                    }
                }

                tr[i].style.display = rowContainsFilter ? "" : "none";
            }
        }
    </script>
</body>
</html>