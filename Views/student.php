<!DOCTYPE html>
<html lang="es">

<?php
include("../Includes/Header.php");

include_once("../DAO/SyncDAO.php");
include_once("../DAO/CourseDAO.php");
include_once("../Connection/Connection.php");
include_once("../Controller/StudentController.php");

$connection = new Connection();
$studentController = new StudentController();

$connection->OpenConnection();
$students = $studentController->GetStudentsByCourse($connection, array("WS" => true), $courseId);
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
                        <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
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
                                <th scope="col">Nombres</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Último Acceso</th>
                                <th scope="col">CustomFields</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($students); $i++) {
                                $state = $students[$i][SyncDAO::$STATE_COLUMN];
                                $class = $state == SyncDAO::$STATE_OK_COLUMN ? 'success' :  '';
                                $class = $state == SyncDAO::$STATE_UPDATE_COLUMN ? 'warning' : $class;
                                $class = $state == SyncDAO::$STATE_ERROR_COLUMN ? 'danger'  : $class;
                                echo '<tr class="alert alert-' . $class . '">'
                                    . '<th scope="row">' . $students[$i][StudentDAO::$ID_COLUMN] . '</th>'
                                    . '<td>' . $students[$i][StudentDAO::$FIRST_NAME_COLUMN] . '</td>'
                                    . '<td>' . $students[$i][StudentDAO::$LAST_NAME_COLUMN] . '</td>'
                                    . '<td>' . $students[$i][StudentDAO::$EMAIL_COLUMN] . '</td>'
                                    . '<td>' . toMilisecondsToDate($students[$i][StudentDAO::$LAST_ACCESS_COURSE_COLUMN]) . '</td>'
                                    . '<td>' . $students[$i][StudentDAO::$CUSTOM_FIELDS_COLUMN] . '</td>'
                                    . '<td>' . $students[$i][SyncDAO::$STATE_COLUMN] . '</td>'
                                    . '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 text-right">
                <button type="button" class="btn btn-success" id="btn-sync" 
                    onclick="sync(this, 'student', null, {courseId: <?php echo $courseId ?>})">
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