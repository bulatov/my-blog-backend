<?php

return [
    'Origin'                           => ['http://localhost:3000'],
    'Access-Control-Request-Method'    => ['POST', 'GET'],
    'Access-Control-Allow-Credentials' => true,
    'Access-Control-Max-Age'           => 3600,
    'Access-Control-Request-Headers'     => ['X-Requested-With'],
];
