<?php
return [
    "type" => "text",
    "text" => "Оцените шаву",
    "reply_type" => "buttons",
    "buttons" => [[
        ["text" => "Оценить шаверму","callback_data" => json_encode(["route"=>""])],
        ["text" => "вернуться","callback_data" => "someString"]],
    ],
    "set_one_time" => true,
    "state" => ""
];
