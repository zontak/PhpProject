<?php

define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ACTION', 'index');
define('DEFAULT_VIEW', 'index');
define('DEFAULT_LAYOUT', 'default');
define('PROJECT_DIR', '/Forum');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'forum_db');

$categories = array(
	1 => 'PHP',
	2 => 'C#',
	3 => 'Database',
	4 => 'Frontend'
);

global $categories;