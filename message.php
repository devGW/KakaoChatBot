<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $content = $data["content"];

    switch($content)
    {
            case "학생식당":
                echo '
                {
                    "message":
                    {
                        "text": "학생식당을 선택하였습니다.."
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["학생식당", "교직원식당", ""]
                    }
                }';
            break;

        case "교직원식당":
            echo '
                {
                    "message":
                    {
                        "text": "교직원식당을 선택하였습니다.."
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["학생식당", "교직원식당", ""]
                    }
                }';
            break;
        default:
            echo '
                {
                    "message":
                    {
                        "text": "잘못된 벨류입니다."
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["학생식당", "교직원식당", ""]
                    }
                }';
            break;
    }
?>
