<?php
include_once("../DAO/ActivityDAO.php");
include_once("../DAO/SyncDAO.php");
include_once("../DAO/EndPointDAO.php");

$activityDAO = new ActivityDAO();
$endPointDAO = new EndPointDAO();

class ActivityController
{

    function GetActivitiesByCourseAndModule($conn, $parameter, $courseId, $moduleId)
    {
        global $activityDAO;
        global $endPointDAO;
        if ($parameter["WS"]) {
            $data = [];
            $jsonModules = '[
                {
                    "id": 1,
                    "name": "General",
                    "visible": 1,
                    "summary": "",
                    "summaryformat": 1,
                    "section": 0,
                    "hiddenbynumsections": 0,
                    "uservisible": true,
                    "modules": []
                },
                {
                    "id": 2,
                    "name": "Modulo 1",
                    "visible": 1,
                    "summary": "",
                    "summaryformat": 1,
                    "section": 1,
                    "hiddenbynumsections": 0,
                    "uservisible": true,
                    "modules": [
                        {
                            "id": 2,
                            "url": "http://192.168.100.175/moodlesena/mod/workshop/view.php?id=2",
                            "name": "Taller prueba",
                            "instance": 1,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/workshop/1581604637/icon",
                            "modname": "workshop",
                            "modplural": "Talleres",
                            "availability": null,
                            "indent": 1,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 2,
                            "completiondata": {
                                "state": 1,
                                "timecompleted": 1581463078,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 6,
                            "url": "http://192.168.100.175/moodlesena/mod/assign/view.php?id=6",
                            "name": "Tarea 1",
                            "instance": 1,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/assign/1581604637/icon",
                            "modname": "assign",
                            "modplural": "Tareas",
                            "availability": null,
                            "indent": 1,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 9,
                            "url": "http://192.168.100.175/moodlesena/mod/lesson/view.php?id=9",
                            "name": "lesson1",
                            "instance": 1,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/lesson/1581604637/icon",
                            "modname": "lesson",
                            "modplural": "Lecciones",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 15,
                            "url": "http://192.168.100.175/moodlesena/mod/hvp/view.php?id=15",
                            "name": "Electrodomesticos",
                            "instance": 5,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/hvp/1581604637/icon",
                            "modname": "hvp",
                            "modplural": "Contenido interactivo",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 17,
                            "url": "http://192.168.100.175/moodlesena/mod/hvp/view.php?id=17",
                            "name": "Cartas",
                            "instance": 7,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/hvp/1581604637/icon",
                            "modname": "hvp",
                            "modplural": "Contenido interactivo",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 18,
                            "url": "http://192.168.100.175/moodlesena/mod/hvp/view.php?id=18",
                            "name": "Microbit",
                            "instance": 8,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/hvp/1581604637/icon",
                            "modname": "hvp",
                            "modplural": "Contenido interactivo",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 19,
                            "url": "http://192.168.100.175/moodlesena/mod/hvp/view.php?id=19",
                            "name": "Partes Microbit",
                            "instance": 9,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/hvp/1581604637/icon",
                            "modname": "hvp",
                            "modplural": "Contenido interactivo",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        }
                    ]
                },
                {
                    "id": 7,
                    "name": "Modulo 2",
                    "visible": 1,
                    "summary": "",
                    "summaryformat": 1,
                    "section": 2,
                    "hiddenbynumsections": 0,
                    "uservisible": true,
                    "modules": [
                        {
                            "id": 11,
                            "url": "http://192.168.100.175/moodlesena/mod/hvp/view.php?id=11",
                            "name": "Nombres de animales",
                            "instance": 1,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/hvp/1581604637/icon",
                            "modname": "hvp",
                            "modplural": "Contenido interactivo",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 13,
                            "url": "http://192.168.100.175/moodlesena/mod/hvp/view.php?id=13",
                            "name": "Prueba",
                            "instance": 3,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/hvp/1581604637/icon",
                            "modname": "hvp",
                            "modplural": "Contenido interactivo",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        }
                    ]
                },
                {
                    "id": 8,
                    "name": "Modulo 3",
                    "visible": 1,
                    "summary": "",
                    "summaryformat": 1,
                    "section": 3,
                    "hiddenbynumsections": 0,
                    "uservisible": true,
                    "modules": [
                        {
                            "id": 7,
                            "url": "http://192.168.100.175/moodlesena/mod/workshop/view.php?id=7",
                            "name": "taller 3",
                            "instance": 3,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/workshop/1581604637/icon",
                            "modname": "workshop",
                            "modplural": "Talleres",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        },
                        {
                            "id": 10,
                            "url": "http://192.168.100.175/moodlesena/mod/assign/view.php?id=10",
                            "name": "tarea sec 3",
                            "instance": 2,
                            "visible": 1,
                            "uservisible": true,
                            "visibleoncoursepage": 1,
                            "modicon": "http://192.168.100.175/moodlesena/theme/image.php/boost/assign/1581604637/icon",
                            "modname": "assign",
                            "modplural": "Tareas",
                            "availability": null,
                            "indent": 0,
                            "onclick": "",
                            "afterlink": null,
                            "customdata": "\"\"",
                            "completion": 1,
                            "completiondata": {
                                "state": 0,
                                "timecompleted": 0,
                                "overrideby": null,
                                "valueused": false
                            }
                        }
                    ]
                }
            ]';
            
            $localCourses = $this->GetActivitiesByCourseAndModule($conn, array("WS" => false), $courseId, $moduleId);
            $rsModules = toStdToArray(json_decode($jsonModules));
            for ($i = 0; $i < count($rsModules); $i++) {
                if ($rsModules[$i][ActivityDAO::$ID_COLUMN] == $moduleId) {
                    $rs = $rsModules[$i]['modules'];
                    print_r($rs);
                    //TODO: Disponer la información en la estructura adecuada para poder hacer la consulta
                    /*$localCourse = $this->GetStateLocalCourses($localCourses, $rs[$i]);
                    array_push(
                        $data,
                        array(
                            ActivityDAO::$ID_COLUMN  => $rs[$i][ActivityDAO::$ID_COLUMN],
                            ActivityDAO::$NAME_COLUMN  => $rs[$i][ActivityDAO::$NAME_COLUMN],
                            SyncDAO::$STATE_COLUMN  => $localCourse[SyncDAO::$STATE_COLUMN]
                        )
                    );*/
                }
            }
        } else {
            $data = $activityDAO->GetActivitiesByCourseAndModule($conn, $courseId, $moduleId);
        }
        return $data;
    }

    function GetStateLocalCourses($localCourses, $course)
    {
        $courseRS = array(
            SyncDAO::$STATE_COLUMN => SyncDAO::$STATE_ERROR_COLUMN,
            SyncDAO::$DESCRIPTION_COLUMN = ""
        );
        for ($i = 0; $i < count($localCourses); $i++) {
            $courseRS[SyncDAO::$STATE_COLUMN] = $course[ActivityDAO::$ID_COLUMN] == $localCourses[$i][ActivityDAO::$ID_COLUMN] && $course[ActivityDAO::$TIME_MODIFIED_COLUMN] == $localCourses[$i][ActivityDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_OK_COLUMN : $courseRS[SyncDAO::$STATE_COLUMN];
            $courseRS[SyncDAO::$STATE_COLUMN] = $course[ActivityDAO::$ID_COLUMN] == $localCourses[$i][ActivityDAO::$ID_COLUMN] && $course[ActivityDAO::$TIME_MODIFIED_COLUMN] != $localCourses[$i][ActivityDAO::$TIME_MODIFIED_COLUMN] ? SyncDAO::$STATE_UPDATE_COLUMN : $courseRS[SyncDAO::$STATE_COLUMN];
        }
        return $courseRS;
    }
}
