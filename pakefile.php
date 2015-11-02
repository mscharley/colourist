<?php

pake_desc('Run CI tasks');
pake_task('ci', 'phpcs', 'phpunit');
function run_ci() {}

pake_desc('Run PHPCS');
pake_task('phpcs');
function run_phpcs() {
  pake_sh('vendor/bin/phpcs lib');
}

pake_desc('Run PHPUnit tests');
pake_task('phpunit');
function run_phpunit() {
  pake_sh('vendor/bin/phpunit tests');
}
