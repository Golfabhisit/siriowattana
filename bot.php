<?php
#-------------------------[Include]-------------------------#
require_once('./include/line_class.php');
require_once('./unirest-php-master/src/Unirest.php');
#-------------------------[Token]-------------------------#
$channelAccessToken = 'ng3BRecedJM0YSJO86LGxGbNzMR988yo6ryOXmFtdmCtkv+dKTElnVhi8fVQJFagzWq+rjLdRTSrOvolZ7OK5Fuy+kVWtHqyxbD5RiS/YgZuq9KO2bDAG9l3cL1hAOGPQ599CR6XPhRJCKuEfs4QxQdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '6cc8129e3f5734779495fe994bf5a7e8';
#-------------------------[Events]-------------------------#
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId     = $client->parseEvents()[0]['source']['userId'];
$groupId    = $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp  = $client->parseEvents()[0]['timestamp'];
$type       = $client->parseEvents()[0]['type'];
$message    = $client->parseEvents()[0]['message'];
$profile    = $client->profil($userId);
$repro = json_encode($profile);
$messageid  = $client->parseEvents()[0]['message']['id'];
$msg_type      = $client->parseEvents()[0]['message']['type'];
$msg_message   = $client->parseEvents()[0]['message']['text'];
$msg_title     = $client->parseEvents()[0]['message']['title'];
$msg_address   = $client->parseEvents()[0]['message']['address'];
$msg_latitude  = $client->parseEvents()[0]['message']['latitude'];
$msg_longitude = $client->parseEvents()[0]['message']['longitude'];


#----command option----#
$usertext = explode(" ", $message['text']);
$command = $usertext[0];
$options = $usertext[1];
if (count($usertext) > 2) {
    for ($i = 2; $i < count($usertext); $i++) {
        $options .= '+';
        $options .= $explode[$i];
    }
}

#------------------------------------------


$modex = file_get_contents('./user/' . $userId . 'mode.json');


if ($modex == 'Normal') {
    $uri = "https://script.google.com/macros/s/AKfycbyldjsu6mMDl-V-0VH2wtXNbfBMS14I4SbAaF44aRfCL7S6TiQ/exec"; 
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $results = array_filter($json['user'], function($user) use ($command) {
    return $user['id'] == $command;
    }
  );

$i=0;
$ff = array();
foreach($results as $resultsz){
$ff[$i] = $resultsz;
$i++;
}


$textz .= "กรุณาระบุ*SITE DONOR JOB*ที่ต้องการค้นหา";
$textz .= "\n";
$textz .= $ff['0']['name'];
$textz .= "\n";
$textz .= $ff['1']['name'];
$textz .= "\n";
$textz .= $ff['2']['name'];
$textz .= "\n";
$textz .= $ff['3']['name'];
$textz .= "\n";
$textz .= $ff['4']['name'];
$textz .= "\n";
$textz .= $ff['5']['name'];
$textz .= "\n";
$textz .= $ff['6']['name'];
$textz .= "\n";
$textz .= $ff['7']['name'];
$textz .= "\n";
$textz .= $ff['8']['name'];
$textz .= "\n";
$textz .= $ff['9']['name'];
$textz .= "\n";
$textz .= $ff['10']['name'];
    $mreply = array(
        'replyToken' => $replyToken,
        'messages' => array( 
          array(
                'type' => 'text',
                'text' => $textz
     )
     )
     );

$enbb = json_encode($ff);
    file_put_contents('./user/' . $userId . 'data.json', $enbb);
    file_put_contents('./user/' . $userId . 'mode.json', 'keyword');
}

elseif ($modex == 'keyword') {
    $urikey = file_get_contents('./user/' . $userId . 'data.json');
    $deckey = json_decode($urikey, true);

    $results = array_filter($deckey, function($user) use ($command) {
    return $user['name'] == $command;
    }
  );


$i=0;
$zaza = array();
foreach($results as $resultsz){
$zaza[$i] = $resultsz;
$i++;
}

$enzz = json_encode($zaza);
    file_put_contents('./user/' . $userId . 'data.json', $enzz);

$text .= "result";
$text .= " \n";
$text .= $zaza[0][TEAM];
$text .= " \n";
$text .= $zaza[0][WBS];
$text .= " \n ";
$text .= $zaza[0][BRAND OLT];
$text .= " \n ";
$text .= $zaza[0][PON];
$text .= " \n ";
$text .= $zaza[0][INSTALLATION DATE];
$text .= " \n ";
$text .= $zaza[0][STATUS];
$text .= " \n ";
$text .= $zaza[0][PHOTO ON WEB];
$text .= " \n ";
$text .= $zaza[0][REMARK PHOTO];
$text .= " \n ";
$text .= $zaza[0][STATUS PHOTO];
$text .= " \n ";
$text .= $zaza[0][STATUS DOC];
$text .= " \n ";
$text .= $zaza[0][REMARK];
$text .= " \n ";
$text .= $zaza[0][SSR ID];
$text .= " \n ";
$text .= $zaza[0][STATUS TPT];
    $mreply = array(
        'replyToken' => $replyToken,
        'messages' => array( 
          array(
                'type' => 'text',
                'text' => $text
     )
     )
     );

    file_put_contents('./user/' . $userId . 'mode.json', 'Normal');
}
else {
  file_put_contents('./user/' . $userId . 'mode.json', 'Normal');
}





if (isset($mreply)) {
    $result = json_encode($mreply);
    $client->replyMessage($mreply);
}  

?>