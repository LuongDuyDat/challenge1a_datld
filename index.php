<?php

require 'db.php';

$config = require 'config.php';

$db = new Database($config['database'], 'root', 'dat123');

$accounts = $db->query("Select * From account");

var_dump($accounts);