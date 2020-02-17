<?php
include_once('../Utils/Utils.php');

class SyncDAO
{
    public static $ID_SYNC_COLUMN = "id";
    public static $STATE_COLUMN = "state";
    public static $DESCRIPTION_COLUMN = "description";
    public static $DATETIME_COLUMN = "datetime";
    public static $ID_ENTITY_COLUMN = "id_entity";
    public static $TABLE_COLUMN = "table";

    public static $STATE_UPDATE_COLUMN = "POR ACTUALIZAR";
    public static $STATE_OK_COLUMN = "SINCRONIZADO";
    public static $STATE_ERROR_COLUMN = "SIN SINCRONIZAR";

    /**
     * Filter array only pending for sync
     *
     * @param array $data
     * @return array
     */
    static function filterForSync(array $data): array
    {
        return array_filter($data, function ($key) {
            return $key['state'] != SyncDAO::$STATE_OK_COLUMN;
        }, ARRAY_FILTER_USE_BOTH);
    }
}
