<?php
include_once('../Utils/Utils.php');

class EnsenameDAO
{
    //public static $HOST = "http://192.168.100.153:8000/";//"Servidor"
    public static $HOST = "http://localhost:8000/";//"Local"
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
