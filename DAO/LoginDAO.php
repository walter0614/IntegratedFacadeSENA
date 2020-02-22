<?php
include_once('../Utils/Utils.php');

class LoginDAO
{
    public static $LOGIN_TABLE_NAME = "user";
    public static $ID_COLUMN = "Id";
    public static $NAME_COLUMN = "Name";
    public static $PASS_COLUMN = "Pass";

    public static function GetUserByLogin($conn, $user, $pass)
    {
        $columns = array(LoginDAO::$ID_COLUMN, LoginDAO::$NAME_COLUMN, LoginDAO::$PASS_COLUMN);
        $query = "SELECT " . toString($columns)
            . " FROM " . LoginDAO::$LOGIN_TABLE_NAME
            . " WHERE " . LoginDAO::$NAME_COLUMN . "=?"
            . " AND " . LoginDAO::$PASS_COLUMN . "=?";
        $data = $conn->Query($query, array($user, $pass));
        return $data;
    }
}
