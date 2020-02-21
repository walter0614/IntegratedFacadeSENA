<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");

include_once("../DAO/SyncDAO.php");
include_once("../DAO/ActivityDAO.php");
include_once("../Connection/Connection.php");
include_once("../Controller/DeliveryController.php");

$connection = new Connection();
$deliveryController = new DeliveryController();

$connection->OpenConnection();
$deliveries = $deliveryController->GetActivityByIdAndStudents($connection, array("WS" => true), $courseId, $activityId);
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
                        <li class="breadcrumb-item"><a href="<?php echo "module.php?idCategory=" . $categoryId . "&nameCategory=" . $categoryName . "&idCourse=" . $courseId . "&nameCourse=" . $courseName ?>">Modulos</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo "activity.php?idCategory=" . $categoryId . "&nameCategory=" . $categoryName . "&idCourse=" . $courseId . "&nameCourse=" . $courseName . "&idModule=" . $moduleId . "&nameModule=" . $moduleName ?>">Actividades</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Entregas</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 text-center">
                <h3><?php echo $activityName ?></h3>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <table class="table table-borderless table-responsive" id="tableCategories">
                        <thead>
                            <tr>
                                <th scope="col">Estudiante</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Nota</th>
                                <th scope="col">Feedback</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Archivos</th>
                                <th scope="col">% Maximo</th>
                                <th scope="col">% Minimo</th>
                                <th scope="col">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($deliveries); $i++) {
                                $state = $deliveries[$i][SyncDAO::$STATE_COLUMN];
                                $class = $state == SyncDAO::$STATE_OK_COLUMN ? 'success' :  '';
                                $class = $state == SyncDAO::$STATE_UPDATE_COLUMN ? 'warning' : $class;
                                $class = $state == SyncDAO::$STATE_ERROR_COLUMN ? 'danger'  : $class;
                                echo '<tr class="alert alert-' . $class . '">'
                                    . '<th scope="row">' . $deliveries[$i][DeliveryDAO::$USER_NAME_COLUMN] . '</th>'
                                    . '<td>' . $deliveries[$i][SyncDAO::$STATE_COLUMN] . '</td>'
                                    . '<td>' . $deliveries[$i][DeliveryDAO::$GRADE_RAW_COLUMN] . '</td>'
                                    . '<td>' . $deliveries[$i][DeliveryDAO::$FEEDBACK_COLUMN] . '</td>'
                                    . '<td>' . toMilisecondsToDate($deliveries[$i][DeliveryDAO::$GRADE_DATE_GRADED_COLUMN]) . '</td>'
                                    . '<td>';
                                if (count($deliveries[$i]["files"]) > 0) {
                                    for ($j = 0; $j < count($deliveries[$i]["files"]); $j++) {
                                        echo '<a href="' . $deliveries[$i]["files"][$j]["fileurl"] . '" target="_blank">'
                                            . $deliveries[$i]["files"][$j]["filename"]
                                            . '</a><br>';
                                    }
                                }
                                echo '</td>'
                                    . '<td>' . $deliveries[$i][DeliveryDAO::$GRADE_MAX_COLUMN] . '</td>'
                                    . '<td>' . $deliveries[$i][DeliveryDAO::$GRADE_MIN_COLUMN] . '</td>'
                                    . '<td>' . $deliveries[$i][DeliveryDAO::$ITEM_MODULE_COLUMN] . '</td>'
                                    . '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 text-right">
                <button type="button" class="btn btn-success" id="btn-sync" 
                    onclick="sync(this, 'delivery', null, {courseId: <?php echo $courseId ?>, activityId: <?php echo $activityId ?>})">
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