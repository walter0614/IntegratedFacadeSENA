<?php
include_once('../Utils/Utils.php');

class EnsenameDAO
{
    public static $HOST = "http://localhost:8000/";
    public static $INSTANCE_NAME = "api/";
    public static $TOKEN = "";

    public static function getEndPoint($function, $parameters = null)
    {
        $endPoint = EnsenameDAO::$HOST
            . EnsenameDAO::$INSTANCE_NAME
            . $function
            . EnsenameDAO::$TOKEN
            . (strlen($parameters) > 0 ? "&" . $parameters : "");

        return $endPoint;
    }
}
