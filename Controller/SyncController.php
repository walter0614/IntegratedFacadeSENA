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

        $mac = exec('cat /sys/class/net/eno1/address');

        $ws = EnsenameDAO::getEndPoint($type);
        $postData = http_build_query((object) [$type => $dataFiltered, 'mac' => $mac]);

        $options = [
            'http' => [
                'method' => "POST",
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postData,
                'ignore_errors' => true,
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

        $response = toStdToArray(json_decode($wsEnsename, true));

        if (isset($response['error']) && $response['error']) {
            return [
                'status' => false,
                'msg' => $response['msg'],
            ];
        }

        return [
            'status' => true,
            'data' => $response,
        ];
    }
}
