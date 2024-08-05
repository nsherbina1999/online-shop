<?php

// This configuration file defines the available courier services.
// Each entry maps a courier name to its corresponding service class.

return [
    'default' => env('COURIER_SERVICE', 'novaposhta'),
];
