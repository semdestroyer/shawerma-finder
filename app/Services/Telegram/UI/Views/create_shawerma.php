<?php
return [
    "type" => "text",
    "text" => "Добавить шаверму",
    "reply_type" => "keyboard",
    "keys" => [
        [
            ["text" => "Выслать мою позицию для шавермы🧭","request_location"=>true],
        ],
        [
            ["text" => "Вернуться"]
        ]
    ],
    "clear_previous_reply" => true,
    "set_one_time" => true,
    "state" => "wait_location_create"
];
