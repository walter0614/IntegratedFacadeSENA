<?php
include_once("../DAO/CategoryDAO.php");
include_once("../DAO/SyncDAO.php");
include_once("../DAO/EndPointDAO.php");

$categoryDAO = new CategoryDAO();
$endPointDAO = new EndPointDAO();

class CategoryController
{

    function GetCategories($conn, $parameter)
    {
        global $categoryDAO;
        global $endPointDAO;
        if ($parameter["WS"]) {
            $data = [];
            $ws = $endPointDAO->GetEndPoint("core_course_get_categories", "");
            $localCategories = $this->GetCategories($conn, array("WS" => false));
            $rs = toStdToArray(json_decode(file_get_contents($ws), true));
            for ($i = 0; $i < count($rs); $i++) {
                $localCategory = $this->GetStateLocalCategory($localCategories, $rs[$i]);
                array_push(
                    $data,
                    array(
                        CategoryDAO::$ID_COLUMN  => $rs[$i][CategoryDAO::$ID_COLUMN],
                        CategoryDAO::$NAME_COLUMN  => $rs[$i][CategoryDAO::$NAME_COLUMN],
                        CategoryDAO::$DESCRIPTION_COLUMN  => $rs[$i][CategoryDAO::$DESCRIPTION_COLUMN],
                        CategoryDAO::$PARENT_COLUMN  => $rs[$i][CategoryDAO::$PARENT_COLUMN],
                        CategoryDAO::$VISIBLE_COLUMN  => $rs[$i][CategoryDAO::$VISIBLE_COLUMN],
                        CategoryDAO::$TIME_MODIFIED_COLUMN  => $rs[$i][CategoryDAO::$TIME_MODIFIED_COLUMN],
                        SyncDAO::$STATE_COLUMN  => $localCategory[SyncDAO::$STATE_COLUMN],
                    )
                );
            }
        } else {
            $data = $categoryDAO->GetCategories($conn);
        }
        return $data;
    }

    function GetStateLocalCategory($localCategories, $category)
    {
        $categoryRS = array(
            SyncDAO::$STATE_COLUMN => SyncDAO::$STATE_ERROR_COLUMN,
            SyncDAO::$DESCRIPTION_COLUMN = ""
        );
        for ($i = 0; $i < count($localCategories); $i++) {
            $categoryRS[SyncDAO::$STATE_COLUMN] = $category[CategoryDAO::$ID_COLUMN] == $localCategories[$i][CategoryDAO::$ID_COLUMN] && $category[CategoryDAO::$TIME_MODIFIED_COLUMN] == $localCategories[$i][CategoryDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_OK_COLUMN : $categoryRS[SyncDAO::$STATE_COLUMN];
            $categoryRS[SyncDAO::$STATE_COLUMN] = $category[CategoryDAO::$ID_COLUMN] == $localCategories[$i][CategoryDAO::$ID_COLUMN] && $category[CategoryDAO::$TIME_MODIFIED_COLUMN] != $localCategories[$i][CategoryDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_UPDATE_COLUMN : $categoryRS[SyncDAO::$STATE_COLUMN];
        }
        return $categoryRS;
    }

    function syncCategory($connection)
    {
        $data = SyncDAO::filterForSync([$this->GetCategories($connection, ['WS' => true])]);

        if (!$data) {
            return [
                'status' => false,
                'msg' => 'No hay ninguna categoria pendiente por sincronizar.',
            ];
        }

        foreach ($data as $key => $value) {
            //var_dump($value['state']);
        }

        return ['status' => true];
    }

    function syncCategoryInEnsename()
    {
        //
    }
}
