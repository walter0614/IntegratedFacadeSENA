<?php

/**
 * 
 * @param type $columns array with values
 * @return string for inserting o make some projections
 */
function toString($columns)
{
    $ret = "";
    $size = count($columns) - 1;
    if ($size < 0) {
        return $ret;
    }
    for ($i = 0; $i < $size; $i++) {
        $ret .= $columns[$i] . ",";
    }
    $ret .= $columns[$size];
    return $ret;
}

/**
 * 
 * @param type $rs stdClass object to array
 * @return array 
 */
function toStdToArray($rs)
{
    foreach ($rs as $key => $value) {
        $rs[$key] = (array) $value;
    }
    return $rs;
}

function toMilisecondsToDate($miliSeconds)
{
    return date("Y-m-d H:i:s", $miliSeconds);
}
