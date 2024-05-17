<?php

return [
    'avg' => [
        'retention' => [
            'count' => 4,
            // should be a method name that exists within carbon interval
            // https://carbon.nesbot.com/docs/#api-interval
            'unit' => 'months',
        ],
    ],
];
