<?php
include_once('../Utils/Utils.php');

class CategoryDAO
{
    public static $CATEGORY_TABLE_NAME = "category";
    public static $ID_CATEGORY_COLUMN = "id_category";
    public static $ID_COLUMN = "id";
    public static $NAME_COLUMN = "name";
    public static $DESCRIPTION_COLUMN = "description";
    public static $PARENT_COLUMN = "parent";
    public static $VISIBLE_COLUMN = "visible";
    public static $TIME_MODIFIED_COLUMN = "timemodified";

    public static function GetCategories($conn)
    {
        $columns = array(
            CategoryDAO::$ID_COLUMN,
            CategoryDAO::$NAME_COLUMN,
            CategoryDAO::$DESCRIPTION_COLUMN,
            CategoryDAO::$PARENT_COLUMN,
            CategoryDAO::$VISIBLE_COLUMN,
            CategoryDAO::$TIME_MODIFIED_COLUMN
        );
        $query = "SELECT " . toString($columns)
            . " FROM " . CategoryDAO::$CATEGORY_TABLE_NAME;
        $data = $conn->Query($query, array());
        return $data;
    }

    public static function saveCategory($conn, array $data): void
    {
        $columns = [
            CategoryDAO::$ID_COLUMN,
            CategoryDAO::$NAME_COLUMN,
            CategoryDAO::$DESCRIPTION_COLUMN,
            CategoryDAO::$PARENT_COLUMN,
            CategoryDAO::$VISIBLE_COLUMN,
            CategoryDAO::$TIME_MODIFIED_COLUMN
        ];

        $query = "INSERT INTO " . CategoryDAO::$CATEGORY_TABLE_NAME
            . " (" . toString($columns) . ")"
            . " VALUES (" . $data['id'] . ", '" . $data['name'] . "', '" . $data['description'] . "', "
            . $data['parent'] . ", " . $data['visible'] . ", '" . $data['timemodified'] . "')";

        $conn->Query($query);
    }

    public static function updateCategory($conn, array $data): void
    {
        $query = "UPDATE " . CategoryDAO::$CATEGORY_TABLE_NAME
            . " SET " . CategoryDAO::$NAME_COLUMN . " = '" . $data['name'] . "', "
            . CategoryDAO::$DESCRIPTION_COLUMN . " = '" . $data['description'] . "', "
            . CategoryDAO::$TIME_MODIFIED_COLUMN . " = '" . $data['timemodified'] . "'"
            . " WHERE " . CategoryDAO::$ID_COLUMN . " = " . $data['id'];

        $conn->Query($query);
    }
}
