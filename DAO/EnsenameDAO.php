<?php
include_once('../Utils/Utils.php');

class EnsenameDAO
{
    //public static $HOST = "http://35.232.253.155:8001/";//"Servidor"
    public static $HOST = "http://localhost:8001/";//"Local"
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
