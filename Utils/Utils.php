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
