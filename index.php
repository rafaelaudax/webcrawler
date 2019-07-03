<?php

use WebCrawler\App;

ignore_user_abort(true);
set_time_limit(0);

require_once __DIR__. '/bootstrap.php';

define('FILE_NAME', 'sabo-site-code');
define('TYPE_CRAWLER', 'sabo-site-code');

App::init();
