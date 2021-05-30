<?php
return [
    "type" => "text",
    "text" => "Приветствую тебя любитель шавермы🌯 \n Выбери один из пунктов:",
    "reply_type" => "buttons",
    "buttons" => [[
        ["text" => "Добавить шаверму","callback_data"=>json_encode(["route"=>"add"])],

        ["text" => "Найти шаверму","callback_data"=>json_encode(["route"=>"find"])],
         ]
    ],
    "clear_previous_reply" => true,
    "set_one_time" => true,
    "state" => null
];
