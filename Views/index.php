<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");
session_start();
$state = isset($_GET['state']) &&  $_GET['state'] == base64_encode('error') ? 1 : 0;
session_destroy();
?>

<body>
    <div class="container div-login">
        <div class="row">
            <div class="col-12" align="center">
                <?php
                if ($state == 1) {
                    echo '<div class="alert alert-danger" role="alert">Credenciales Incorrectas</div>';
                }
                ?>
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-body">
                        <h3 class="card-title">Iniciar Sesión</h3>
                        <form action="../POST/LoginPOST.php" method="POST">
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
</body>

<?php
include("../Includes/Footer.php");
?>

</html>