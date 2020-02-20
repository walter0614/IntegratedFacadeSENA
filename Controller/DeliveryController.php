<?php
include_once("../DAO/DeliveryDAO.php");
include_once("../DAO/SyncDAO.php");
include_once("../DAO/EndPointDAO.php");

$deliveryDAO = new DeliveryDAO();
$endPointDAO = new EndPointDAO();

class DeliveryController
{

    function GetActivityByIdAndStudents($conn, $parameter, $courseId, $activityId)
    {
        global $deliveryDAO;
        global $endPointDAO;

        if ($parameter["WS"]) {
            $data = [];
            $ws = $endPointDAO->GetEndPoint("gradereport_user_get_grade_items", "courseid=" . $courseId);
            $localActivities = $this->GetActivityByIdAndStudents($conn, array("WS" => false), $courseId, $activityId);
            $filterAssignments = $this->FilterAssignments($courseId, $activityId);
            $rs = toStdToArray(json_decode(file_get_contents($ws), true))[DeliveryDAO::$USER_GRADES_COLUMN];
            for ($i = 0; $i < count($rs); $i++) {
                for ($k = 0; $k < count($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN]); $k++) {
                    if ($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$ITEM_NAME_COLUMN] && $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$CM_ID_COLUMN] == $activityId) {
                        $activityLocal = $this->GetStateLocal($localActivities, $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k], $rs[$i][DeliveryDAO::$USER_ID_COLUMN]);
                        $filesActivities = $this->GetFilesByActivity($filterAssignments, $rs[$i][DeliveryDAO::$USER_ID_COLUMN]);
                        array_push(
                            $data,
                            array(
                                DeliveryDAO::$USER_NAME_COLUMN  => strlen($rs[$i][DeliveryDAO::$USER_NAME_COLUMN]) > 0 ? $rs[$i][DeliveryDAO::$USER_NAME_COLUMN] : null,
                                SyncDAO::$STATE_COLUMN  => strlen($activityLocal[SyncDAO::$STATE_COLUMN]) > 0 ? $activityLocal[SyncDAO::$STATE_COLUMN] : null,
                                DeliveryDAO::$GRADE_RAW_COLUMN => strlen($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_RAW_COLUMN]) > 0 ? $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_RAW_COLUMN] : null,
                                DeliveryDAO::$FEEDBACK_COLUMN => strlen($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$FEEDBACK_COLUMN]) > 0 ? $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$FEEDBACK_COLUMN] : null,
                                DeliveryDAO::$GRADE_MAX_COLUMN => strlen($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_MAX_COLUMN]) > 0 ? $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_MAX_COLUMN] : null,
                                DeliveryDAO::$GRADE_MIN_COLUMN => strlen($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_MIN_COLUMN]) > 0 ? $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_MIN_COLUMN] : null,
                                DeliveryDAO::$ITEM_MODULE_COLUMN => strlen($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$ITEM_MODULE_COLUMN]) > 0 ? $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$ITEM_MODULE_COLUMN] : null,
                                DeliveryDAO::$GRADE_DATE_GRADED_COLUMN => strlen($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_DATE_GRADED_COLUMN]) > 0 ? $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_DATE_GRADED_COLUMN] : null,
                                "files" => $filesActivities
                            )
                        );
                    }
                }
            }
        } else {
            $data = $deliveryDAO->GetActivityByIdAndStudents($conn,  $activityId);
        }
        return $data;
    }

    function GetStateLocal($localActivities, $activity, $userId)
    {
        $activityRS = array(
            SyncDAO::$STATE_COLUMN => SyncDAO::$STATE_ERROR_COLUMN,
            SyncDAO::$DESCRIPTION_COLUMN = ""
        );
        for ($i = 0; $i < count($localActivities); $i++) {
            $activityRS[SyncDAO::$STATE_COLUMN] = $activity[DeliveryDAO::$CM_ID_COLUMN] == $localActivities[$i][DeliveryDAO::$CM_ID_COLUMN] && $userId == $localActivities[$i][DeliveryDAO::$USER_ID_COLUMN] && $activity[DeliveryDAO::$GRADE_DATE_GRADED_COLUMN] == $localActivities[$i][DeliveryDAO::$GRADE_DATE_GRADED_COLUMN] ? SyncDAO::$STATE_OK_COLUMN : $activityRS[SyncDAO::$STATE_COLUMN];
            $activityRS[SyncDAO::$STATE_COLUMN] = $activity[DeliveryDAO::$CM_ID_COLUMN] == $localActivities[$i][DeliveryDAO::$CM_ID_COLUMN] && $userId == $localActivities[$i][DeliveryDAO::$USER_ID_COLUMN] && $activity[DeliveryDAO::$GRADE_DATE_GRADED_COLUMN] != $localActivities[$i][DeliveryDAO::$GRADE_DATE_GRADED_COLUMN] ? SyncDAO::$STATE_UPDATE_COLUMN : $activityRS[SyncDAO::$STATE_COLUMN];
        }
        return $activityRS;
    }

    function GetAssignmentIDByActivityID($courseId, $activityId)
    {
        global $endPointDAO;

        $assignmentId = 0;
        $ws = $endPointDAO->GetEndPointSpecial("mod_assign_get_assignments", "courseids[]=" . $courseId);
        $rs = toStdToArray(json_decode(file_get_contents($ws), true))["courses"];
        for ($i = 0; $i < count($rs); $i++) {
            for ($k = 0; $k < count($rs[$i]["assignments"]); $k++) {
                $assignmentId = $rs[$i]["assignments"][$k]["cmid"] == $activityId ? $rs[$i]["assignments"][$k]["id"] : $assignmentId;
            }
        }
        return $assignmentId;
    }

    function FilterAssignments($courseId, $activityId)
    {
        global $endPointDAO;

        $data = [];
        $assignmentId = $this->GetAssignmentIDByActivityID($courseId, $activityId);
        if ($assignmentId > 0) {
            $ws = $endPointDAO->GetEndPoint("mod_assign_get_submissions", "assignmentids[]=" . $assignmentId);
            $rs = toStdToArray(json_decode(file_get_contents($ws), true))["assignments"];
            for ($i = 0; $i < count($rs); $i++) {
                for ($k = 0; $k < count($rs[$i]["submissions"]); $k++) {
                    for ($l = 0; $l < count($rs[$i]["submissions"][$k]["plugins"]); $l++) {
                        if ($rs[$i]["submissions"][$k]["plugins"][$l]["type"] == "file") {
                            for ($m = 0; $m < count($rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"]); $m++) {
                                if ($rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"][$m]["area"] == "submission_files") {
                                    for ($n = 0; $n < count($rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"][$m]["files"]); $n++) {
                                        array_push(
                                            $data,
                                            array(
                                                "userid" => $rs[$i]["submissions"][$k]["userid"],
                                                "filename" => $rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"][$m]["files"][$n]["filename"],
                                                "filesize" => $rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"][$m]["files"][$n]["filesize"],
                                                "timemodified" => $rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"][$m]["files"][$n]["timemodified"],
                                                "fileurl" => $rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"][$m]["files"][$n]["fileurl"] . $endPointDAO->GetFiles(),
                                                "mimetype" => $rs[$i]["submissions"][$k]["plugins"][$l]["fileareas"][$m]["files"][$n]["mimetype"]
                                            )
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    function GetFilesByActivity($allFiles, $idUser)
    {
        $data = [];

        for ($i = 0; $i < count($allFiles); $i++) {
            if ($allFiles[$i]["userid"] == $idUser) {
                array_push(
                    $data,
                    $allFiles[$i]
                );
            }
        }
        return $data;
    }

    function syncDelivery($connection, int $courseId, int $activityId)
    {
        global $deliveryDAO;

        $data = $this->GetActivityByIdAndStudents($connection, ['WS' => true], $courseId, $activityId);
        $dataSync = SyncController::syncInEnsename($data, 'delivery');

        if (!$dataSync['status']) {
            return $dataSync;
        }

        $errors = [];
        foreach ($dataSync['data'] as $key => $value) {

            if ($value['status']) {

                if ($value['state'] == 'POR ACTUALIZAR') {
                    $deliveryDAO->updateDelivery($connection, $value);
                } else {
                    $deliveryDAO->saveDelivery($connection, $value);
                }
            } else {
                $errors[] = $value;
            }
        }

        return ['status' => true, 'msg' => 'Sincronizado exitosamente', 'errors' => $errors];
    }
}
