<?php
session_start();
$state = isset($_GET['state']) &&  $_GET['state'] == base64_encode('error') ? 1 : 0;
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Server Etraining One</title>

    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/main.css">
</head>

<body>
    <div class="container div-login">
        <div class="row">
            <div class="col-12" align="center">
                <?php
                if ($state == 1) {
                    echo '<div class="alert alert-danger" role="alert">Credenciales Incorrectas</div>';
                }
                ?>
                <div class="card" style="width: 30rem">
                    <div class="card-body">
                        <h3 class="card-title">Iniciar Sesión</h3>
                        <form action="POST/LoginPOST.php" method="POST">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control form-control-lg" name="user" required>
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control form-control-lg" name="pass" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg ">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="JS/jquery-3.4.1.slim.min.js"></script>
    <script src="JS/popper.min.js"></script>
    <script src="JS/bootstrap.min.js"></script>
</body>

</html>