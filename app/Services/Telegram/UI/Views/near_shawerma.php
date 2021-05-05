<?php
return [
    "type" => "text",
    "text" => "Получить ближайшую шаверму U+1F32F",
    "reply_type" => "buttons",
    "keys" => [
        [
            ["text" => "Выслать мою позицию \xF0\x9F\x8F\xA0","request_location"=>true],
            ["text" => "Найти по адресу"]
        ],
        [["text" => "вернуться"]]
    ],
    "buttons" => [[
        ["text" => "button","callback_data" => "someString"],
        ["text" => "button","callback_data" => "someString"]],
    ],

    "state" => ""
];
