<?php
include_once('../Utils/Utils.php');

class DeliveryDAO
{
    public static $DELIVERY_TABLE_NAME = "delivery";
    public static $ID_DELIVERY_COLUMN = "id_delivery";
    public static $ITEM_NAME_COLUMN = "itemname";
    public static $ID_COLUMN = "id";
    public static $ITEM_MODULE_COLUMN = "itemmodule";
    public static $CM_ID_COLUMN = "cmid";
    public static $GRADE_MIN_COLUMN = "grademin";
    public static $GRADE_MAX_COLUMN = "grademax";
    public static $GRADE_RAW_COLUMN = "graderaw";
    public static $GRADE_DATE_GRADED_COLUMN = "gradedategraded";
    public static $FEEDBACK_COLUMN = "feedback";
    public static $USER_ID_COLUMN = "userid";
    public static $USER_GRADES_COLUMN = "usergrades";
    public static $GRADE_ITEMS_COLUMN = "gradeitems";
    public static $USER_NAME_COLUMN = "userfullname";

    public static function GetActivityByIdAndStudents($conn, $activityId)
    {
        $columns = array(
            DeliveryDAO::$ID_DELIVERY_COLUMN,
            DeliveryDAO::$ID_COLUMN,
            DeliveryDAO::$ITEM_MODULE_COLUMN,
            DeliveryDAO::$CM_ID_COLUMN,
            DeliveryDAO::$GRADE_MIN_COLUMN,
            DeliveryDAO::$GRADE_MAX_COLUMN,
            DeliveryDAO::$GRADE_RAW_COLUMN,
            DeliveryDAO::$GRADE_DATE_GRADED_COLUMN,
            DeliveryDAO::$FEEDBACK_COLUMN,
            DeliveryDAO::$USER_ID_COLUMN
        );
        $query = "SELECT " . toString($columns)
            . " FROM " . DeliveryDAO::$DELIVERY_TABLE_NAME
            . " WHERE " . DeliveryDAO::$CM_ID_COLUMN . "=?";
        $data = $conn->Query($query, array($activityId));
        return $data;
    }

    public static function saveDelivery($conn, array $data): void
    {
        $columns = [
            DeliveryDAO::$ID_COLUMN,
            DeliveryDAO::$ITEM_MODULE_COLUMN,
            DeliveryDAO::$CM_ID_COLUMN,
            DeliveryDAO::$GRADE_MIN_COLUMN,
            DeliveryDAO::$GRADE_MAX_COLUMN,
            DeliveryDAO::$GRADE_RAW_COLUMN,
            DeliveryDAO::$GRADE_DATE_GRADED_COLUMN,
            DeliveryDAO::$FEEDBACK_COLUMN,
            DeliveryDAO::$USER_ID_COLUMN
        ];

        $query = "INSERT INTO " . DeliveryDAO::$DELIVERY_TABLE_NAME
            . " (" . toString($columns) . ")"
            . " VALUES (" . $data['id'] . ", '" . $data['itemmodule'] . "', "
            . "'" . $data['cmid'] . "', '" . $data['grademin'] . "', '" . $data['grademax'] . "', "
            . "'" . $data['graderaw'] . "', '" . $data['gradedategraded'] . "', " 
            . "'" . $data['feedback'] . "', '" . $data['userid'] . "')";

        $conn->Query($query);
    }

    public static function updateDelivery($conn, array $data): void
    {
        $query = "UPDATE " . DeliveryDAO::$DELIVERY_TABLE_NAME
            . " SET " . DeliveryDAO::$ITEM_MODULE_COLUMN . " = '" . $data['itemmodule'] . "', "
            . DeliveryDAO::$CM_ID_COLUMN . " = '" . $data['cmid'] . "', "
            . DeliveryDAO::$GRADE_MIN_COLUMN . " = '" . $data['grademin'] . "', "
            . DeliveryDAO::$GRADE_MAX_COLUMN . " = '" . $data['grademax'] . "', "
            . DeliveryDAO::$GRADE_RAW_COLUMN . " = '" . $data['graderaw'] . "', "
            . DeliveryDAO::$GRADE_DATE_GRADED_COLUMN . " = '" . $data['gradedategraded'] . "', "
            . DeliveryDAO::$FEEDBACK_COLUMN . " = '" . $data['feedback'] . "', "
            . DeliveryDAO::$USER_ID_COLUMN . " = '" . $data['userid'] . "'"
            . " WHERE " . DeliveryDAO::$ID_COLUMN . " = " . $data['id'];

        $conn->Query($query);
    }
}
