<?php
return [
    "type" => "text",
    "text" => "Получить ближайшую шаверму 🌯🏠",
    "reply_type" => "keys",
    "keys" => [
        [
                ["text" => "Выслать мою позицию 🧭","request_location"=>true],
        ],
        [
            ["text" => "вернуться"]
        ]
    ],
    "state" => "WAIT_LOCATION"
];
