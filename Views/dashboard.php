<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");
include("../Includes/Session.php");

include_once("../DAO/SyncDAO.php");
include_once("../DAO/CategoryDAO.php");
include_once("../Connection/Connection.php");
include_once("../Controller/CategoryController.php");
$connection = new Connection();
$categoryController = new CategoryController();

$connection->OpenConnection();
$categories = $categoryController->GetCategories($connection, array("WS" => true));
?>

<body>
    <?php
    include("../Includes/Navbar.php");
    ?>
    <div class="container">
        <div class="row" style="padding-top:5%">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Categorias</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <table class="table table-borderless table-responsive" id="tableCategories">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Última Modificación</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Cursos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($categories); $i++) {
                                $class = $categories[$i][SyncDAO::$STATE_COLUMN];
                                $class = $class == SyncDAO::$STATE_OK_COLUMN ? 'success' : $class == SyncDAO::$STATE_UPDATE_COLUMN ? 'warning' : 'danger';
                                echo '<tr class="alert alert-' . $class . '">'
                                    . '<th scope="row">' . $categories[$i][CategoryDAO::$ID_COLUMN] . '</th>'
                                    . '<td>' . $categories[$i][CategoryDAO::$NAME_COLUMN] . '</td>'
                                    . '<td>' . $categories[$i][CategoryDAO::$DESCRIPTION_COLUMN] . '</td>'
                                    . '<td>' . toMilisecondsToDate($categories[$i][CategoryDAO::$TIME_MODIFIED_COLUMN]) . '</td>'
                                    . '<td>' . $categories[$i][SyncDAO::$STATE_COLUMN] . '</td>'
                                    . '<td><a class="btn btn-primary btn-sm" href="course.php?id=' . $categories[$i][CategoryDAO::$ID_COLUMN] . '&name=' . $categories[$i][CategoryDAO::$NAME_COLUMN] . '">Cursos</a></td>'
                                    . '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 text-right">
                <button type="button" class="btn btn-success" onclick="sync(this, 'category')">
                    Sincronizar
                </button>
            </div>
        </div>
    </div>
</body>


<?php
$connection->Close();
include("../Includes/Footer.php");
?>

</html>