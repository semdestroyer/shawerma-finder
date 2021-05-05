<?php
return [
    "type" => "text",
    "text" => "test",
    "reply_type" => "buttons",
    "keys" => [[
        ["text" => "button \xF0\x9F\x8F\xA0","request_location"=>true],["text" => "button"]],
        [["text" => "button"]]
    ],
    "buttons" => [[
        ["text" => "button","callback_data" => "someString"],
        ["text" => "button","callback_data" => "someString"]],
    ],

    "state" => ""
];
