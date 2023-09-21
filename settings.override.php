<?php
$databases['default']['default'] = array (
  'database' => 'ddd',
  'username' => 'root',
  'password' => '',
  'prefix' => '',
  'host' => 'mysql',
  'port' => '3306',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'driver' => 'mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);

$settings['config_sync_directory'] = '../config/sync';
