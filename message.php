<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $content = $data["content"];


    $tt = date(Ymd);
    $json = file_get_contents("./".$tt."menu.json");
    $result_json = json_decode($json, true);

    $key = array();
    $key = array_keys($result_json);


    switch($content)
    {
            case "Student":
                echo '
                {
                    "message":
                    {
                        "text": "메뉴1을 선택하셨습니다.'.$result_json[뚝배기][data][0].'"
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["Student", "Professor", "menu3"]
                    }
                }';
            break;
        case "Professor":
            echo '
                {
                    "message":
                    {
                        "text": "메뉴2를 선택하셨습니다."
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["Student", "Professor", "menu3"]
                    }
                }';
            break;
        case "menu3":
            echo '
                {
                    "message":
                    {
                        "text": "메뉴3을 선택하셨습니다."
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["menu1", "menu2", "menu3"]
                    }
                }';
            break;
        default:
            echo '
                {
                    "message":
                    {
                        "text": "잘못된 값입니다."
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["Student", "Professor", "menu3"]
                    }
                }';
            break;
    }

?>
