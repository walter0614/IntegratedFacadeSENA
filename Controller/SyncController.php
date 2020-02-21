<?php
require_once("../DAO/SyncDAO.php");
require_once("../DAO/EnsenameDAO.php");
require_once('../Utils/Utils.php');

class SyncController
{
    public static function syncInEnsename(array $data, string $type): array
    {
        $dataFiltered = SyncDAO::filterForSync($data);

        if (!$dataFiltered) {
            return [
                'status' => false,
                'msg' => 'No hay nada pendiente por sincronizar.',
            ];
        }

        $ws = EnsenameDAO::getEndPoint($type);
        $postData = http_build_query((object) [$type => $dataFiltered]);

        $options = [
            'http' => [
                'method' => "POST",
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postData,
            ]
        ];

        $context = stream_context_create($options);

        $wsEnsename = @file_get_contents($ws, false, $context);

        if ($wsEnsename === FALSE) {
            return [
                'status' => false,
                'msg' => 'Falló la conexión con Enseñame, intente más tarde.',
            ];
        }

        return [
            'status' => true,
            'data' => toStdToArray(json_decode($wsEnsename, true)),
        ];
    }
}
