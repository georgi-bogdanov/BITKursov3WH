<?php

return array(
    '_root_' => 'home/index', // The default route
    '_404_' => 'errors/404', // The main 404 route
    'pages/(:any)' => 'pages/index/$1',
);
