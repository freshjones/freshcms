<?php

Route::post('/dialogflow/demo', function(\Illuminate\Http\Request $request){

    $file = __DIR__ . '/../demo.txt';

    file_put_contents($file, print_r($request->all(),true) );
  

    $intent = $request->queryResult['intent']['displayName'];
  
    $session = session($request->session, array());

    $request->session()->push($request->session, array(
        'intent' => $intent,
    ));

    $message = 'Default message';

    $messages = array();

    $quickreplyjson = '[
        "fulfillmentText": "OK, Lets get started, what location do you use?"
    ]';

    $json = '[
        {
            "text": {
              "text": [
                "OK, Try these classes"
              ]
            }
        },
        {
            "card": {
              "title": "Swim Lessons",
              "subtitle": "Private Swim Youth - 20pack - 30minute private lessons",
              "buttons": [
                {
                    "text": "Register Now",
                    "postback": "https://www.google.com"
                }
              ]
            }
        },
        {
            "card": {
              "title": "15296 - Personal Training and Specialty: Synergy 1 - Bundle",
              "subtitle": "Small group training utilizing our Synergy unit.",
              "buttons": [
                {
                    "text": "Register Now",
                    "postback": "https://www.google.com"
                }
              ]
            }
        }
    ]';

    $return = '';
    

    return $return;
   
});
