<?php
require_once 'autoloader_test.php';
spl_autoload_register(array('AutoloaderTest','loadtest'));
AutoloaderTest::loadGlobal();