<?php
session_start();

    $code = $_GET['code'];

    if($code == ""){
        header("location: index.php");
        exit;
    }

    $client_ID = "795ef7834bae13934590";
    $CLIENT_SECRET = "6fe6661bee4b7bb39f472203d5a85c456c0b8420";
    $URL = 'https://github.com/login/oauth/access_token';

    $postParams = [
        'client_id' => $client_ID,
        'client_secret' => $CLIENT_SECRET,
        'code' => $code
    ];
    
// get access token
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$URL);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$postParams);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Accept: application/json'));  
    $output=curl_exec($ch);
    curl_close($ch);

    $data = json_decode($output);
    $accessToken = $data->access_token;
    echo 'access_token = '.$accessToken;
 
       // get username
        $URL = "https://api.github.com/user";
        $authHeader = "Authorization: token ".$accessToken;
        $userAgentHeader = "User-Agent: task5";

        $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$URL);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HTTPHEADER,array('Accept: application/json', $authHeader, $userAgentHeader));  //to avoid NULL result 
            $output=curl_exec($ch);
            curl_close($ch);

            $data = json_decode($output,true);
            echo'<br>';
            $username =$data['login'];
            //echo $username;

            //get email
            $URL = "https://api.github.com/user/emails?";
            $authHeader = "Authorization: token ".$accessToken;
            $userAgentHeader = "User-Agent: task5";

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$URL);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HTTPHEADER,array('Accept: application/json', $authHeader, $userAgentHeader));  //to avoid NULL result 
            $output=curl_exec($ch);
            curl_close($ch);

            $data = json_decode($output,true);
            $email = $data[0]['email'];
          
            session_start();
            $_SESSION['user'] = $username;
            $_SESSION['email'] = $email;
            header("location: password.php");

