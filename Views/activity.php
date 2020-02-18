<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");
include("../Includes/Session.php");

include_once("../DAO/SyncDAO.php");
include_once("../DAO/ActivityDAO.php");
include_once("../Connection/Connection.php");
include_once("../Controller/ActivityController.php");

$moduleId = isset($_GET['id']) ? $_GET['id'] : 0;
$moduleName = isset($_GET['name']) ? $_GET['name'] : 0;
$courseId = isset($_GET['courseid']) ? $_GET['courseid'] : 0;

$connection = new Connection();
$activityController = new ActivityController();

$connection->OpenConnection();
$activities = $activityController->GetActivitiesByCourseAndModule($connection, array("WS" => true), $courseId, $moduleId);
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
                        <li class="breadcrumb-item"><a href="dashboard.php">Cursos</a></li>
                        <li class="breadcrumb-item"><a href="dashboard.php">Módulos y Sesiones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Actividades</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 text-center">
                <h3><?php echo $moduleName ?></h3>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <table class="table table-borderless table-responsive" id="tableCategories">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($activities); $i++) {
                                
                                $state = $activities[$i][SyncDAO::$STATE_COLUMN];
                                $class = $state == SyncDAO::$STATE_OK_COLUMN ? 'success' :  '';
                                $class = $state == SyncDAO::$STATE_UPDATE_COLUMN ? 'warning' : $class;
                                $class = $state == SyncDAO::$STATE_ERROR_COLUMN ? 'danger'  : $class;
                                echo '<tr class="alert alert-' . $class . '">'
                                    . '<th scope="row">' . $activities[$i][ActivityDAO::$ID_COLUMN] . '</th>'
                                    . '<td>' . $activities[$i][ActivityDAO::$NAME_COLUMN] . '</td>'
                                    . '<td>' . $activities[$i][ActivityDAO::$TIPO_ACTIVITY] . '</td>'
                                    . '<td>' . $activities[$i][SyncDAO::$STATE_COLUMN] . '</td>'
                                    . '<td>'  . '</td>'
                                    . '<td>'
                                    . '<button class="btn btn-success btn-sm">Entregas</button>'
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