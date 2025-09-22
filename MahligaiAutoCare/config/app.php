<?php
// config/app.php

return [
    'app_name' => 'Mahligai Auto Care',
    'base_url' => 'http://localhost/ProjectBpwMVC/MahligaiAutoCare/public', 
    'database' => [
        'host' => '127.0.0.1',
        'dbname' => 'mahligai_db',
        'username' => 'root',
        'password' => ''
    ],
    
    'admin_roles' => ['admin1', 'admin2'],
    'super_admin_role' => 'admin1',
];