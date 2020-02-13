<?php
include_once('../Utils/Utils.php');

class EndPointDAO
{
    public static $HOST = "http://192.168.100.175/";
    public static $INSTANCE_NAME = "moodlesena/webservice/rest/server.php?";
    public static $TOKEN = "wstoken=be36ba0fa968207d3e75bb00d186b636";
    public static $FUNCTION_NAME = "&wsfunction=";
    public static $FORMAT = "&moodlewsrestformat=json";

    function GetEndPoint($function, $parameters)
    {
        $endPoint = EndPointDAO::$HOST
            . EndPointDAO::$INSTANCE_NAME
            . EndPointDAO::$TOKEN
            . EndPointDAO::$FUNCTION_NAME
            . $function
            . EndPointDAO::$FORMAT
            . (strlen($parameters) > 0 ? "&" . $parameters : "");
        return $endPoint;
    }
}
