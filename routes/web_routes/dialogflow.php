<?php

Route::post('/dialogflow/demo', function(\Illuminate\Http\Request $request){

    //$file = __DIR__ . '/../demo.txt';

    //file_put_contents($file, print_r($request->all(),true) );
  
   // if(!$request->queryResult)
      //  return;

    $intent = $request->queryResult['intent']['displayName'];
  
    $session = session($request->session, array());

    $request->session()->push($request->session, array(
        'intent' => $intent,
    ));

    $message = 'Default message';

    $messages = array();

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

    switch($intent)
    {
        case 'Ask-findclass':
             $return = json_decode('{ 
                "fulfillmentText": "OK, Lets get started, what location do you use?", 
                "data": {
                  "facebook": {
                     "text": "Pick a location:",
                     "quick_replies": [
                            {
                                "content_type": "text",
                                "title": "Red",
                                "payload": "red"
                            },
                            {
                                "content_type": "text",
                                "title": "Green",
                                "payload": "green"
                            }
                        ]
                    }
                }
            }', true);
        break;

        case 'Ask-location':
            $message = 'Excellent, Are you looking for a class this fall?';
            $return = [ 'fulfillmentText'=> $message, ];
        break;

        case 'Ask-session':
            $message = 'ok, what type of class are you looking for?';
            $return = [ 'fulfillmentText'=> $message, ];
        break;

        case 'Ask-class':
            $message = 'What days of the week do you want the class on?';
            $return = [ 'fulfillmentText'=> $message, ];
        break;

        case 'Ask-days':
            $message = "How about this class? \n\n 14590 - Swim Lessons: Private Swim Youth - 20pack - 30minute private lessons";
            $return = [ 'fulfillmentMessages'=> json_decode($json, true), ];
        break;

    }

    return $return;
   
});
