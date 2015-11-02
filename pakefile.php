<?php

pake_desc('Run CI tasks');
pake_task('ci', 'phpunit');

function run_ci() {}

pake_desc('Run PHPUnit tests');
pake_task('phpunit');

function run_phpunit() {
  system('vendor/bin/phpunit tests');
}
