<?php

require 'core/db.php';

$config = require 'config.php';

$db = new Database($config['database'], 'root', 'dat123');

require 'routes.php';