<?php
include_once("../DAO/ActivityDAO.php");
include_once("../DAO/SyncDAO.php");
include_once("../DAO/EndPointDAO.php");

$activityDAO = new ActivityDAO();
$endPointDAO = new EndPointDAO();

class ActivityController
{

    function GetActivitiesByCourseAndModule($conn, $parameter, $courseId, $moduleId)
    {
        global $activityDAO;
        global $endPointDAO;

      if ($parameter["WS"]) {
            $data = [];
            $ws = $endPointDAO->GetEndPoint("core_course_get_contents", "courseid=" . $courseId);
            $localActivity = $this->GetActivitiesByCourseAndModule($conn, array("WS" => false), $courseId,$moduleId);
            $rsModules = toStdToArray(json_decode(file_get_contents($ws), true));
            for ($i = 0; $i < count($rsModules); $i++) {
                $activityLocal = $this->GetStateLocalactivity($localActivity, $rsModules[$i]);
                if ($rsModules[$i][ActivityDAO::$ID_COLUMN] == $moduleId) {
                    $rsInt = $rsModules[$i]["modules"];
                    for($x=0; $x < count($rsInt); $x++ ){
                        for($j=0;$j<count(ActivityDAO::$TYPES_ACTIVITY); $j++){
                        if (ActivityDAO::$TYPES_ACTIVITY[$j] == $rsInt[$x][ActivityDAO::$TIPO_ACTIVITY]){
                    array_push(
                    $data,
                    array(
                        ActivityDAO::$ID_COLUMN  => $rsInt[$x][ActivityDAO::$ID_COLUMN],
                        ActivityDAO::$NAME_COLUMN  => $rsInt[$x][ActivityDAO::$NAME_COLUMN],
                        ActivityDAO::$TIPO_ACTIVITY  => $rsInt[$x][ActivityDAO::$TIPO_ACTIVITY],
                        SyncDAO::$STATE_COLUMN  => $activityLocal[SyncDAO::$STATE_COLUMN]
                    )
                );
                }
                }
                }
                }
                }
            }
        else {
            $data = $activityDAO->GetActivitiesByCourseAndModule($conn, $courseId, $moduleId);
        }
        return $data;
      
            
           
    }

    function GetStateLocalactivity($localActivity, $activity)
    {
        $activityRS = array(
            SyncDAO::$STATE_COLUMN => SyncDAO::$STATE_ERROR_COLUMN,
            SyncDAO::$DESCRIPTION_COLUMN = ""
        );
        for ($i = 0; $i < count($localActivity); $i++) {
            $activityRS[SyncDAO::$STATE_COLUMN] = $activity[ActivityDAO::$ID_COLUMN] == $localActivity[$i][ActivityDAO::$ID_COLUMN] && $activity[ActivityDAO::$TIME_MODIFIED_COLUMN] == $localActivity[$i][ActivityDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_OK_COLUMN : $activityRS[SyncDAO::$STATE_COLUMN];
            $activityRS[SyncDAO::$STATE_COLUMN] = $activity[ActivityDAO::$ID_COLUMN] == $localActivity[$i][ActivityDAO::$ID_COLUMN] && $activity[ActivityDAO::$TIME_MODIFIED_COLUMN] != $localActivity[$i][ActivityDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_UPDATE_COLUMN : $activityRS[SyncDAO::$STATE_COLUMN];
        }
        return $activityRS;
    }
}
