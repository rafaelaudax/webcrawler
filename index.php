<?php

use WebCrawler\App;

ignore_user_abort(true);
set_time_limit(0);

require_once __DIR__. '/bootstrap.php';

define('FILE_NAME', 'volvo');
define('TYPE_CRAWLER', 'volvo');

App::init();
