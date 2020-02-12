<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");
include("../Includes/Session.php");

include_once("../DAO/CategoryDAO.php");
include_once("../Controller/CategoryController.php");
include_once("../Connection/Connection.php");
$connection = new Connection();
$categoryController = new CategoryController();

$connection->OpenConnection();
$categories = $categoryController->GetCategories($connection, array("WS" => true));
$categoriesDB = $categoryController->GetCategories($connection, array("WS" => false));
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
                                echo '<tr>'
                                    . '<th scope="row">' . $categories[$i][CategoryDAO::$ID_COLUMN] . '</th>'
                                    . '<td>' . $categories[$i][CategoryDAO::$NAME_COLUMN] . '</td>'
                                    . '<td>' . $categories[$i][CategoryDAO::$DESCRIPTION_COLUMN] . '</td>'
                                    . '<td>' . $categories[$i][CategoryDAO::$TIME_MODIFIED_COLUMN] . '</td>'
                                    . '<td>X</td>'
                                    . '<td><button class="btn btn-primary">Cursos</button></td>'
                                    . '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>


<?php
$connection->Close();
include("../Includes/Footer.php");
?>

</html>