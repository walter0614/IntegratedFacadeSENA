<?php
include_once('../Utils/Utils.php');

class EndPointDAO
{
    public static $HOST = "http://35.232.253.155:8003/";
    public static $INSTANCE_NAME = "moodlesena/webservice/rest/server.php?";
    public static $TOKEN = "wstoken=be36ba0fa968207d3e75bb00d186b636";
    public static $TOKEN_SPECIAL = "wstoken=d3f7683501e2c68d162a316c891f7e88";
    public static $FUNCTION_NAME = "&wsfunction=";
    public static $FORMAT = "&moodlewsrestformat=json";
    public static $GET_FILES = "?forcedownload=1&token=";

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

    function GetEndPointSpecial($function, $parameters)
    {
        $endPoint = EndPointDAO::$HOST
            . EndPointDAO::$INSTANCE_NAME
            . EndPointDAO::$TOKEN_SPECIAL
            . EndPointDAO::$FUNCTION_NAME
            . $function
            . EndPointDAO::$FORMAT
            . (strlen($parameters) > 0 ? "&" . $parameters : "");
        return $endPoint;
    }
    function GetFiles()
    {
        return EndPointDAO::$GET_FILES . str_replace("wstoken=", "", EndPointDAO::$TOKEN);
    }
}
