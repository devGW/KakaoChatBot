<?php
$data = json_decode(file_get_contents('php://input'), true);
$content = $data["content"];
header('Content-Type: application/json; charset=utf-8');
$tt = date(Ymd);
$today = date("Y/m/d");
$isUniv = file_exists("./univMenu/".$tt."menu.json");
$isDormi = file_exists("./dormiMenu/".$tt."dormitoryMenu.json");

if($isUniv){
    $univJson = file_get_contents("./univMenu/".$tt."menu.json");
    $result_univJson = json_decode($univJson, true);

    $key = array();
    $key = array_keys($result_univJson);

    $title = array();
    $mainMenu = array();

    $studentMenu = "";
    $professorMenu ="";

    for($i=0; $i<count($key);$i++){
      $temp = strpos($key[$i],"M");
      $title[$i] = mb_substr($key[$i], 0,$temp/3);
      if(strpos($result_univJson[$key[$i]][data][0], "치킨돈까스") !== false){
          $mainMenu[$i] = trim(mb_substr($result_univJson[$key[$i]][data][0],0,18,'UTF-8').', '.mb_substr($result_univJson[$key[$i]][data][0],38,8,'UTF-8')).', '.
          mb_substr($result_univJson[$key[$i]][data][0],66,7,'UTF-8').', '.mb_substr($result_univJson[$key[$i]][data][0],94,12,'UTF-8').', '.
          mb_substr($result_univJson[$key[$i]][data][0],127,7,'UTF-8').', '.mb_substr($result_univJson[$key[$i]][data][0],155,7,'UTF-8');
          //문제 발생시 strpos 이용
      } else {
        $mainMenu[$i] = trim($result_univJson[$key[$i]][data][0]);
      }
      if(strpos($title[$i], "특정식") !==false){

           $professorMenu = $professorMenu.$title[$i]." : ".$mainMenu[$i]."\\n\\n";
      } else {
           $studentMenu = $studentMenu.$title[$i]." : ".$mainMenu[$i]."\\n\\n";
      }
    }
} else {
    $studentMenu = "학식메뉴가 업로드 되지 않았습니다.\\n\\n";
    $professorMenu = "교직원식당 메뉴가 업로드 되지 않았습니다.\\n\\n";
}

if($isDormi){

    $dormiJson = file_get_contents("./dormiMenu/".$tt."dormitoryMenu.json");
    $result_dormiJson = json_decode($dormiJson, true);

    $dormiKey = array();
    $dormiKey = array_keys($result_dormiJson);

    $dormiTitle = array();
    $dormiMainMenu = array();

    $dormiBreakMenu = "";
    $dormiDinnerMenu ="";

    for ($i=0; $i <count($dormiKey); $i++) {

      $dormiMainMenu[$i] = $result_dormiJson[$dormiKey[$i]][data][0];
      $dormiTitle[$i] = $dormiKey[$i];

      if(strpos($dormiTitle[$i], "조식") !==false){
          $dormiBreakMenu = $dormiTitle[$i]." : ".$dormiMainMenu[$i]."\\n";
      } else if(strpos($dormiTitle[$i], "석식") !==false){
          $dormiDinnerMenu = $dormiTitle[$i]." : ".$dormiMainMenu[$i]."\\n";
      } else {
        $dormiBreakMenu = "기숙사 점심 메뉴가 업로드 되지 않았습니다.";
        $dormiDinnerMenu = "기숙사 저녁 메뉴가 업로드 되지 않았습니다.\\n\\n".$today;
      }
    }
}
$info = "창업동아리 : NULL \\n\\n가입문의 : 상담원 전환 클릭 \\n\\n제작 : https://github.com/devGW";
switch($content)
{
    case "학생식당":
    echo '
    {
        "message":
        {
            "text": "'.$studentMenu."날짜 : ".$today.'"
            },
            "keyboard":
            {
                "type": "buttons",
                "buttons": ["학생식당", "교직원식당", "기숙사식당", "정보&문의"]
            }
        }';
    break;
  case "교직원식당":
   echo '
   {
      "message":
      {
          "text": "'.$professorMenu."날짜 : ".$today.'"
          },
          "keyboard":
          {
              "type": "buttons",
              "buttons": ["학생식당", "교직원식당", "기숙사식당", "정보&문의"]
          }
      }';
      break;
      case "정보&문의":
      echo '
      {
          "message":
          {
              "text": "'.$info.'"
              },
              "keyboard":
              {
                  "type": "buttons",
                  "buttons": ["학생식당", "교직원식당", "기숙사식당", "정보&문의"]
              }
          }';
          break;
          case "기숙사식당":
           echo '
           {
              "message":
              {
                  "text": "'.$dormiBreakMenu."\\n".$dormiDinnerMenu."\\n날짜 : ".$today.'"
                  },
                  "keyboard":
                  {
                      "type": "buttons",
                      "buttons": ["학생식당", "교직원식당", "기숙사식당", "정보&문의"]
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
                      "buttons": ["학생식당", "교직원식당", "기숙사식당", "정보&문의"]
                  }
              }';
              break;
          }
?>
