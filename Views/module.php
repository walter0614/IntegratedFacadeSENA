<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");

include_once("../DAO/SyncDAO.php");
include_once("../DAO/ModuleDAO.php");
include_once("../Connection/Connection.php");
include_once("../Controller/ModuleController.php");

$connection = new Connection();
$moduleController = new ModuleController();

$connection->OpenConnection();
$modules = $moduleController->GetContentByCourse($connection, array("WS" => true), $courseId);
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
                        <li class="breadcrumb-item"><a href="dashboard.php">Categorias</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo "course.php?idCategory=" . $categoryId . "&nameCategory=" . $categoryName ?>">Cursos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Modulos</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 text-center">
                <h3><?php echo $courseName ?></h3>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <table class="table table-borderless table-responsive" id="tableCategories">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Seccion</th>
                                <th scope="col"># Modulo</th>
                                <th scope="col"># Seccion</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($modules); $i++) {
                                $state = $modules[$i][SyncDAO::$STATE_COLUMN];
                                $class = $state == SyncDAO::$STATE_OK_COLUMN ? 'success' :  '';
                                $class = $state == SyncDAO::$STATE_UPDATE_COLUMN ? 'warning' : $class;
                                $class = $state == SyncDAO::$STATE_ERROR_COLUMN ? 'danger'  : $class;
                                echo '<tr class="alert alert-' . $class . '">'
                                    . '<th scope="row">' . $modules[$i][ModuleDAO::$ID_COLUMN] . '</th>'
                                    . '<td>' . $modules[$i][ModuleDAO::$NAME_COLUMN] . '</td>'
                                    . '<td>' . $modules[$i][ModuleDAO::$SUMARY_COLUMN] . '</td>'
                                    . '<td>' . $modules[$i][ModuleDAO::$SECTION_COLUMN] . '</td>'
                                    . '<td>' . $modules[$i][ModuleDAO::$MODULE_ID_COLUMN] . '</td>'
                                    . '<td>' . $modules[$i][ModuleDAO::$SECTION_ID_COLUMN] . '</td>'
                                    . '<td>' . $modules[$i][SyncDAO::$STATE_COLUMN] . '</td>'
                                    . '<td>'
                                    . '<td><a class="btn btn-primary btn-sm" href="activity.php?idCourse=' . $courseId . '&nameCourse=' . $courseName . '&idCategory=' . $categoryId . '&nameCategory=' . $categoryName . '&idModule=' . $modules[$i][ModuleDAO::$ID_COLUMN] . '&nameModule=' . $modules[$i][ModuleDAO::$NAME_COLUMN] . '">Actividades</a></td>'
                                    . '</td>'
                                    . '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 text-right">
                <button type="button" class="btn btn-success">Sincronizar</button>
            </div>
        </div>
    </div>
</body>


<?php
$connection->Close();
include("../Includes/Footer.php");
?>

</html>