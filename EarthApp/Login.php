<?php
    include("database.php");
    $usuarios = new Database();

    $idUsuario = $usuarios->sanitize($_POST["idUsuario"]);
    $pass = $usuarios->sanitize($_POST["pass"]);

    $res = $usuarios->read($idUsuario, $pass);

    $response = array();
    $response['success'] = false;

    while ($row = mysqli_fetch_object($res)) {
        $response['success'] = true;
        $response['idUsuario'] = $row->idUsuario;
        $response['nombre'] = $row->nombre;
        $response['tipo'] = $row->tipo;
    }

    echo json_encode($response);
?>
