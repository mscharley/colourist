<?php

pake_desc('Run CI tasks');
pake_task('ci', 'phpcs', 'phpunit');
function run_ci() {}

pake_desc('Run PHPCS');
pake_task('phpcs');
function run_phpcs() {
  print pake_sh('vendor/bin/phpcs -s');
}

pake_desc('Run PHPCBF to attempt to fix CS issues');
pake_task('phpcbf');
function run_phpcbf() {
  print pake_sh('vendor/bin/phpcbf');
}

pake_desc('Run PHPMD');
pake_task('phpmd');
function run_phpmd() {
  print pake_sh('vendor/bin/phpmd lib,tests xml cleancode,codesize,controversial,design,unusedcode');
}

pake_desc('Run PHPUnit tests');
pake_task('phpunit');
function run_phpunit() {
  $cc_token = getenv('CODECLIMATE_REPO_TOKEN');
  $cc = !empty($cc_token);
  print pake_sh('vendor/bin/phpunit tests' . ($cc ? ' --coverage-clover build/logs/clover.xml' : ''));
  if ($cc) {
    print pake_sh('vendor/bin/test-reporter');
  }
}
