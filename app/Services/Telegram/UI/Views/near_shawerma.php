<?php
return [
    "type" => "text",
    "text" => "Получить ближайшую шаверму 🌯🏠",
    "reply_type" => "keyboard",
    "keys" => [
        [
                ["text" => "Выслать мою позицию 🧭","request_location"=>true],
        ],
        [
            ["text" => "Вернуться"]
        ]
    ],
    "clear_previous_reply" => true,
    "set_one_time" => true,
    "state" => "wait_location_near"
];
