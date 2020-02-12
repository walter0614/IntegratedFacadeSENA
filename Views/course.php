<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");
include("../Includes/Session.php");

include_once("../DAO/SyncDAO.php");
include_once("../DAO/CourseDAO.php");
include_once("../Connection/Connection.php");
include_once("../Controller/CourseController.php");

$connection = new Connection();
$courseController = new CourseController();

$connection->OpenConnection();
$courses = $courseController->GetCoursesByCategory($connection, array("WS" => true), $_GET['id']);
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
                        <li class="breadcrumb-item active" aria-current="page">Cursos</li>
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
                                <th scope="col">Inicio</th>
                                <th scope="col">Fin</th>
                                <th scope="col">Creación</th>
                                <th scope="col">Última Modificación</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($courses); $i++) {
                                $state = $courses[$i][SyncDAO::$STATE_COLUMN];
                                $class = $state == SyncDAO::$STATE_OK_COLUMN ? 'success' :  '';
                                $class = $state == SyncDAO::$STATE_UPDATE_COLUMN ? 'warning' : $class;
                                $class = $state == SyncDAO::$STATE_ERROR_COLUMN ? 'danger'  : $class;
                                echo '<tr class="alert alert-' . $class . '">'
                                    . '<th scope="row">' . $courses[$i][CourseDAO::$ID_COLUMN] . '</th>'
                                    . '<td>' . $courses[$i][CourseDAO::$NAME_COLUMN] . '</td>'
                                    . '<td>' . $courses[$i][CourseDAO::$START_DATE_COLUMN] . '</td>'
                                    . '<td>' . $courses[$i][CourseDAO::$END_DATE_COLUMN] . '</td>'
                                    . '<td>' . $courses[$i][CourseDAO::$TIME_CREATED_COLUMN] . '</td>'
                                    . '<td>' . $courses[$i][CourseDAO::$TIME_MODIFIED_COLUMN] . '</td>'
                                    . '<td>' . $courses[$i][SyncDAO::$STATE_COLUMN] . '</td>'
                                    . '<td>'
                                    . '<button class="btn btn-primary btn-sm">Modulos</button>'
                                    . '<button class="btn btn-success btn-sm">Estudiantes</button>'
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