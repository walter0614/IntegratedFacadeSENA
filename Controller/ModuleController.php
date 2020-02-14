<?php
include_once("../DAO/ModuleDAO.php");
include_once("../DAO/SyncDAO.php");
include_once("../DAO/EndPointDAO.php");

$moduleDAO = new ModuleDAO();
$endPointDAO = new EndPointDAO();

class ModuleController
{

    function GetContentByCourse($conn, $parameter, $courseId)
    {
        global $moduleDAO;
        global $endPointDAO;
        if ($parameter["WS"]) {
            $data = [];
            $ws = $endPointDAO->GetEndPoint("core_course_get_contents", "courseid=" . $courseId);
            $localModule = $this->GetContentByCourse($conn, array("WS" => false), $courseId);
            $rs = toStdToArray(json_decode(file_get_contents($ws), true));
            for ($i = 1; $i < count($rs); $i++) {
                $moduleLocal = $this->GetStateLocalModule($localModule, $rs[$i]);
                array_push(
                    $data,
                    array(
                        ModuleDAO::$ID_COLUMN  => $rs[$i][ModuleDAO::$ID_COLUMN],
                        ModuleDAO::$NAME_COLUMN  => $rs[$i][ModuleDAO::$NAME_COLUMN],
                        ModuleDAO::$SUMARY_COLUMN  => $rs[$i][ModuleDAO::$SUMARY_COLUMN],
                        ModuleDAO::$SECTION_COLUMN  => $rs[$i][ModuleDAO::$SECTION_COLUMN],
                        SyncDAO::$STATE_COLUMN  => $moduleLocal[SyncDAO::$STATE_COLUMN]
                    )
                );

            }    
        } else {
            $data = $moduleDAO->GetContentByCourse($conn, $courseId);

        }
        return $data;

    
    }

    function GetStateLocalModule($localModule, $module)
    {       
            $moduleRS = array(
            SyncDAO::$STATE_COLUMN => SyncDAO::$STATE_ERROR_COLUMN,
            SyncDAO::$DESCRIPTION_COLUMN = ""
        );
       for ($i = 0; $i < count($localModule); $i++) {
            $moduleRS[SyncDAO::$STATE_COLUMN] = 
            $module[ModuleDAO::$ID_COLUMN] ==
            $localModule[$i][ModuleDAO::$ID_COLUMN]
            && $module[ModuleDAO::$NAME_COLUMN] == $localModule[$i][ModuleDAO::$NAME_COLUMN] ? SyncDAO::$STATE_OK_COLUMN : $moduleRS[SyncDAO::$STATE_COLUMN];
            $moduleRS[SyncDAO::$STATE_COLUMN] = $module[ModuleDAO::$ID_COLUMN] == $localModule[$i][ModuleDAO::$ID_COLUMN] 
            && $module[ModuleDAO::$NAME_COLUMN] != $localModule[$i][ModuleDAO::$NAME_COLUMN] ? SyncDAO::$STATE_UPDATE_COLUMN : $moduleRS[SyncDAO::$STATE_COLUMN];
        }
        return $moduleRS;

    }

}
