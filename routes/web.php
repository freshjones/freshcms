<?php

Auth::routes();

/* setting routes */
require(__DIR__.'/web_routes/setting_routes.php');

/* section routes */
require(__DIR__.'/web_routes/section_routes.php');

/* content routes */
require(__DIR__.'/web_routes/content_routes.php');

/* billboard routes */
require(__DIR__.'/web_routes/billboard_routes.php');
require(__DIR__.'/web_routes/billboard_screen_routes.php');

/* page routes */
require(__DIR__.'/web_routes/page_routes.php');

class Msg{
    public $buttons;
    public $formattedText;
    public $title;
    public $type = "basic_card";
}

class Button{
    public $title;
    public $openUrlAction;
}

class ButtonURL{
    public $url = 'https://www.google.com';
}

function getButtons()
{
    $buttons = array();
    $button = new Button();
    $button->title = 'test';
    $buttonUrl = new ButtonURL();
    $button->openUrlAction = $buttonUrl->url;
    $buttons[] = $button;
    return $buttons;
}

function getMessages()
{
    $messages = array();

    $message1 = new Msg();
    $message1->formattedText = 'OK DOKEY';
    $message1->title = 'SWEET';
    $message1->buttons = getButtons();

    $messages[] = $message1;

    return $messages;    

}
Route::post('/dialogflow/demo', function(\Illuminate\Http\Request $request){

    //$session = $request->session;
    //$query = $request->queryResult;
    //$intent = $query['intent'];

    // return [
    //     'fulfillmentText'=>'Your intent was ' . $request->session;
    // ]; 
    /*
    $fixture = '{"responseId":"832f3a5a-1ee4-4ed8-9367-dbe1d95b152e","queryResult":{"queryText":"yes","parameters":[],"allRequiredParamsPresent":true,"fulfillmentMessages":[{"text":{"text":[null]}}],"intent":{"name":"projects\/ymcademo-v2\/agent\/intents\/e881bba8-6dbf-4f0a-a6b7-ae03ec30e619","displayName":"Ask-findclass"},"intentDetectionConfidence":1,"languageCode":"en"},"originalDetectIntentRequest":{"payload":[]},"session":"projects\/ymcademo-v2\/agent\/sessions\/53e7d232-2883-7967-0e64-44c41f5d1faf"}';

    $data = json_decode($fixture);
    */

    $file = __DIR__ . '/../demo.txt';

    file_put_contents($file, print_r($request->all(),true) );
  

    $intent = $request->queryResult['intent']['displayName'];
  
    $session = session($request->session, array());

    $request->session()->push($request->session, array(
        'intent' => $intent,
    ));

    $message = 'Default message';

    $messages = array();

    switch($intent)
    {
        case 'Ask-findclass':
            $message = 'OK, Lets get started, what YMCA do you use?';
            $return = [ 'fulfillmentText'=> $message, ];
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
            $return = [ 'messages'=> getMessages(), ];
        break;

    }

    return $return;
   
});


