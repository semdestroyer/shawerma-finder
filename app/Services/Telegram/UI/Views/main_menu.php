<?php
return [
    "type" => "text",
    "text" => "Приветствую тебя любитель шавермы🌯 \n Выбери один из пунктов:",
    "reply_type" => "buttons",
    "buttons" => [[
        ["text" => "Добавить шаверму","callback_data"=>"add"],

        ["text" => "Найти шаверму","callback_data"=>"find"],
         ]
    ],
    "state" => null
];
