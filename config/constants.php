<?php

return [
    'httpCode' => [
        'OK' => 200,
        'ServerError' => 500
    ],
    'TRID' => explode('.', gmdate('YmdHis.u'))[0] . substr(explode('.', gmdate('YmdHis.u'))[1], 0, 1) . rand(1001, 9999)
];
