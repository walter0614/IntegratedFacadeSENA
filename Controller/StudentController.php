<?php
include_once("../DAO/StudentDAO.php");
include_once("../DAO/SyncDAO.php");
include_once("../DAO/EndPointDAO.php");

$studentDAO = new StudentDAO();
$endPointDAO = new EndPointDAO();

class StudentController
{

    function GetStudentsByCourse($conn, $parameter, $courseId)
    {
        global $studentDAO;
        global $endPointDAO;

        if ($parameter["WS"]) {
            $data = [];
            $ws = $endPointDAO->GetEndPoint("core_enrol_get_enrolled_users", "courseid=" . $courseId);
            $localStudents = $this->GetStudentsByCourse($conn, array("WS" => false), $courseId);
            $rs = toStdToArray(json_decode(file_get_contents($ws), true));

            for ($i = 0; $i < count($rs); $i++) {
                $studentLocal = $this->GetStateLocalStudent($localStudents, $rs[$i]);
                array_push(
                    $data,
                    array(
                        StudentDAO::$ID_COLUMN => $rs[$i][StudentDAO::$ID_COLUMN],
                        StudentDAO::$FIRST_NAME_COLUMN => $rs[$i][StudentDAO::$FIRST_NAME_COLUMN],
                        StudentDAO::$LAST_NAME_COLUMN => $rs[$i][StudentDAO::$LAST_NAME_COLUMN],
                        StudentDAO::$EMAIL_COLUMN => $rs[$i][StudentDAO::$EMAIL_COLUMN],
                        StudentDAO::$CUSTOM_FIELDS_COLUMN => isset($rs[$i][StudentDAO::$CUSTOM_FIELDS_COLUMN]) ? json_encode($rs[$i][StudentDAO::$CUSTOM_FIELDS_COLUMN]) : '[]',
                        StudentDAO::$ID_COURSE_COLUMN => $courseId,
                        SyncDAO::$STATE_COLUMN => $studentLocal[SyncDAO::$STATE_COLUMN],
                        StudentDAO::$DEPARTMENT_COLUMN => $rs[$i][StudentDAO::$DEPARTMENT_COLUMN],
                        StudentDAO::$FIRST_ACCESS_COLUMN => $rs[$i][StudentDAO::$FIRST_ACCESS_COLUMN],
                        StudentDAO::$LAST_ACCESS_COLUMN => $rs[$i][StudentDAO::$LAST_ACCESS_COLUMN],
                        StudentDAO::$LAST_ACCESS_COURSE_COLUMN => $rs[$i][StudentDAO::$LAST_ACCESS_COURSE_COLUMN],
                    )
                );
            }
        } else {
            $data = $studentDAO->GetStudentsByCourse($conn, $courseId);
        }
        return $data;
    }

    function GetStateLocalStudent($localStudents, $student)
    {
        $studentRS = array(
            SyncDAO::$STATE_COLUMN => SyncDAO::$STATE_ERROR_COLUMN,
            SyncDAO::$DESCRIPTION_COLUMN => ""
        );

        for ($i = 0; $i < count($localStudents); $i++) {
            $studentRS[SyncDAO::$STATE_COLUMN] = $student[StudentDAO::$ID_COLUMN] == $localStudents[$i][StudentDAO::$ID_COLUMN] && $student[StudentDAO::$FIRST_NAME_COLUMN] == $localStudents[$i][StudentDAO::$FIRST_NAME_COLUMN] && $student[StudentDAO::$LAST_NAME_COLUMN] == $localStudents[$i][StudentDAO::$LAST_NAME_COLUMN] && $student[StudentDAO::$EMAIL_COLUMN] == $localStudents[$i][StudentDAO::$EMAIL_COLUMN] && $student[StudentDAO::$CUSTOM_FIELDS_COLUMN] == $localStudents[$i][StudentDAO::$CUSTOM_FIELDS_COLUMN] ? SyncDAO::$STATE_OK_COLUMN : $studentRS[SyncDAO::$STATE_COLUMN];
            $studentRS[SyncDAO::$STATE_COLUMN] = $student[StudentDAO::$ID_COLUMN] == $localStudents[$i][StudentDAO::$ID_COLUMN] && ($student[StudentDAO::$FIRST_NAME_COLUMN] != $localStudents[$i][StudentDAO::$FIRST_NAME_COLUMN] || $student[StudentDAO::$LAST_NAME_COLUMN] != $localStudents[$i][StudentDAO::$LAST_NAME_COLUMN] || $student[StudentDAO::$EMAIL_COLUMN] != $localStudents[$i][StudentDAO::$EMAIL_COLUMN] || $student[StudentDAO::$CUSTOM_FIELDS_COLUMN] != $localStudents[$i][StudentDAO::$CUSTOM_FIELDS_COLUMN]) ? SyncDAO::$STATE_UPDATE_COLUMN : $studentRS[SyncDAO::$STATE_COLUMN];
        }

        return $studentRS;
    }

    function syncStudent($connection, int $courseId)
    {
        global $studentDAO;

        $data = $this->GetStudentsByCourse($connection, ['WS' => true], $courseId);
        $dataSync = SyncController::syncInEnsename($data, 'student');

        if (!$dataSync['status']) {
            return $dataSync;
        }

        $errors = [];
        foreach ($dataSync['data'] as $key => $value) {

            if ($value['status']) {

                if ($value['state'] == 'POR ACTUALIZAR') {
                    $studentDAO->updateStudent($connection, $value);
                } else {
                    $studentDAO->saveStudent($connection, $value);
                }
            } else {
                $errors[] = $value;
            }
        }

        return ['status' => true, 'msg' => 'Sincronizado exitosamente', 'errors' => $errors];
    }
}
