<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $content = $data["content"];


    $tt = date(Ymd);
    $json = file_get_contents("./".$tt."menu.json");
    $result_json = json_decode($json, true);

    $key = array();
    $key = array_keys($result_json);

    $data = json_decode(file_get_contents('php://input'), true);
    $content = $data["content"];
    $tt = date(Ymd);
    $json = file_get_contents("./".$tt."menu.json");
    $result_json = json_decode($json, true);
    $key = array();
    $key = array_keys($result_json);

    $title = array();
    $mainMenu = array();
    for($i=0; $i<count($key);$i++){
      // $tM = $tM.$key[$i]." : ".$result_json[$key[$i]][data][$i]."\n";
      $title[$i] = $key[$i];
      if(strpos($result_json[$key[$i]][data][0], "돈까스") !== false){
          $mainMenu[$i] = trim(mb_substr($result_json[$key[$i]][data][0],0,18,'UTF-8').', '.mb_substr($result_json[$key[$i]][data][0],38,8,'UTF-8')).', '.
          mb_substr($result_json[$key[$i]][data][0],66,7,'UTF-8').', '.mb_substr($result_json[$key[$i]][data][0],94,12,'UTF-8').', '.
          mb_substr($result_json[$key[$i]][data][0],127,7,'UTF-8').', '.mb_substr($result_json[$key[$i]][data][0],155,7,'UTF-8');

      } else {
        $mainMenu[$i] = trim($result_json[$key[$i]][data][0]);
      }

    }
    $studentMenu = "";
    $professorMenu ="";
    for ($i=0; $i < count($key); $i++) {
      if(strpos($title[$i], "특정식") !==false){
        $professorMenu = $professorMenu.$title[$i]." : ".$mainMenu[$i]."\\n";
      } else {
        $studentMenu = $studentMenu.$title[$i]." : ".$mainMenu[$i]."\\n\\n";
      }
    }


    switch($content)
    {
            case "학생식당":
                echo '
                {
                    "message":
                    {
                        "text": "'.$studentMenu.'"
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["학생식당", "교직원식당", "menu3"]
                    }
                }';
            break;
        case "교직원식당":
            echo '
                {
                    "message":
                    {
                        "text": "'.$professorMenu.'"
                    },
                    "keyboard":
                    {
                        "type": "buttons",
                        "buttons": ["학생식당", "교직원식당", "menu3"]
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
                        "buttons": ["학생식당", "교직원식당", "menu3"]
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
                        "buttons": ["학생식당", "교직원식당", "menu3"]
                    }
                }';
            break;
    }

?>
