<?php

require_once '../class/mysql.class.php';
require_once '../../config/database.php';

myPDO::setConfiguration($DB_DSN, $DB_USER, $DB_PASSWORD);
?>
