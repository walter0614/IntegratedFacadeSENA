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
            $rs = toStdToArray(json_decode(file_get_contents($ws), true))[DeliveryDAO::$USER_GRADES_COLUMN];
            for ($i = 0; $i < count($rs); $i++) {
                for ($k = 0; $k < count($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN]); $k++) {
                    if ($rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$ITEM_NAME_COLUMN] && $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$CM_ID_COLUMN] == $activityId) {
                        $activityLocal = $this->GetStateLocal($localActivities, $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k], $rs[$i][DeliveryDAO::$USER_ID_COLUMN]);
                        array_push(
                            $data,
                            array(
                                DeliveryDAO::$USER_NAME_COLUMN  => $rs[$i][DeliveryDAO::$USER_NAME_COLUMN],
                                SyncDAO::$STATE_COLUMN  => $activityLocal[SyncDAO::$STATE_COLUMN],
                                DeliveryDAO::$GRADE_RAW_COLUMN => $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_RAW_COLUMN],
                                DeliveryDAO::$FEEDBACK_COLUMN => $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$FEEDBACK_COLUMN],
                                DeliveryDAO::$GRADE_MAX_COLUMN => $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_MAX_COLUMN],
                                DeliveryDAO::$GRADE_MIN_COLUMN => $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_MIN_COLUMN],
                                DeliveryDAO::$ITEM_MODULE_COLUMN => $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$ITEM_MODULE_COLUMN],
                                DeliveryDAO::$GRADE_DATE_GRADED_COLUMN => $rs[$i][DeliveryDAO::$GRADE_ITEMS_COLUMN][$k][DeliveryDAO::$GRADE_DATE_GRADED_COLUMN]
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
}
