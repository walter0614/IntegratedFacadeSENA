<?php
include_once("../DAO/CategoryDAO.php");

$categoryDAO = new CategoryDAO();

class CategoryController
{

    function GetCategories($conn, $parameter)
    {
        global $categoryDAO;
        if ($parameter["WS"]) {
            $data = [];
            $rs = toStdToArray(json_decode(file_get_contents("http://192.168.100.175/moodlesena/webservice/rest/server.php?wstoken=be36ba0fa968207d3e75bb00d186b636&wsfunction=core_course_get_categories&moodlewsrestformat=json")));
            for ($i = 0; $i < count($rs); $i++) {
                array_push(
                    $data,
                    array(
                        CategoryDAO::$ID_COLUMN  => $rs[$i][CategoryDAO::$ID_COLUMN],
                        CategoryDAO::$NAME_COLUMN  => $rs[$i][CategoryDAO::$NAME_COLUMN],
                        CategoryDAO::$DESCRIPTION_COLUMN  => $rs[$i][CategoryDAO::$DESCRIPTION_COLUMN],
                        CategoryDAO::$PARENT_COLUMN  => $rs[$i][CategoryDAO::$PARENT_COLUMN],
                        CategoryDAO::$VISIBLE_COLUMN  => $rs[$i][CategoryDAO::$VISIBLE_COLUMN],
                        CategoryDAO::$TIME_MODIFIED_COLUMN  => date("Y-m-d", $rs[$i][CategoryDAO::$TIME_MODIFIED_COLUMN]),
                    )
                );
            }
        } else {
            $data = $categoryDAO->GetCategories($conn);
        }
        return $data;
    }
}