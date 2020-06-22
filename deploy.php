<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/rsync.php';
require 'recipe/cachetool.php';

// Project name
set('application', 'sec');
set('default_stage', 'stagging');

// Writable dirs by web server
set('writable_dirs', [
    'var',
    'public',
]);

set('shared_dirs', [
    'var'
]);

set('shared_files', [
    'public/healthcheck.html'
]);

set('rsync', [
    'exclude'      => [
        '.git',
        '.docker-sync',
        '.phan',
        '.sami',
        '.vscode',
        'private',
        'deploy.php',
        'Project/Dev',
        'Tests',
    ],
    'exclude-file' => false,
    'include'      => [],
    'include-file' => false,
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'rz', // Recursive, with compress
    'options'      => ['update', 'delete'],
    'timeout'      => 60,
    'tty'          => true,
]);

set('rsync_src', __DIR__);
set('rsync_dest', '{{release_path}}');
set('allow_anonymous_stats', false);
set('cachetool', '127.0.0.1:9000');
set('unprepare', false);

task('deploy:locale:prepare', function () {
    $stage = get('stage');
    $unprepare = get('unprepare');
    if ($unprepare) {
        runLocally("echo ======= diff files=========================", ['tty' => true]);
        runLocally("git diff --name-only", ['tty' => true]);
        runLocally("echo ===========================================", ['tty' => true]);
        runLocally("composer install --no-dev --optimize-autoloader", ['tty' => true]);
        runLocally("composer build", ['tty' => true]);
        return;
    }
    runLocally("git reset --hard `git rev-list --max-parents=0 --abbrev-commit HEAD`");
    runLocally("git checkout deploy && git pull origin deploy");
    runLocally("composer install --no-dev --optimize-autoloader", ['tty' => true]);
    runLocally("composer build", ['tty' => true]);
})->once();

task('deploy:migration', function () {
    run("{{bin/php}} {{release_path}}/bin/migrations.php migrate", ['tty' => true]);
    run("{{bin/php}} {{release_path}}/bin/console.php dev:doctrine orm:clear-cache:metadata", ['tty' => true]);
    run("{{bin/php}} {{release_path}}/bin/console.php dev:doctrine orm:generate-proxies", ['tty' => true]);
})->once();

task('deploy:clear:cache', function () {
    cd('{{release_path}}');
    run("{{bin/php}} {{release_path}}/bin/console.php cache:clear:all", ['tty' => true]);
})->once();

task('deploy:clear:opcache', function () {
    run("curl http://127.0.0.1/rest/v0/cache");
});

task('deploy:cache:warmup', function () {
    cd('{{release_path}}');
    run("{{bin/php}} {{release_path}}/bin/console.php cache:warmup", ['tty' => true]);
    // run("composer warmup-opcode", ['tty' => true]);
})->once();

task('deploy:env', function () {
    $stage = get('stage');
    if ('production' === $stage) {
        upload('env.production.php', '{{release_path}}/env.php');
        runLocally("git rev-parse HEAD > deploy-production.log");
        run("cp {{deploy_path}}/shared/*.config.php {{release_path}}/config/Production/");
    } elseif ('stagging' === $stage) {
        upload('env.stagging.php', '{{release_path}}/env.php');
        runLocally("git rev-parse HEAD > deploy-stagging.log");
        run("cp {{deploy_path}}/shared/*.config.php {{release_path}}/config/Stagging/");
    } else {
        run("cp {{deploy_path}}/shared/*.config.php {{release_path}}/config/Development/");
    }
    run("rm -rf {{deploy_path}}/shared/var/cache/twig");
});

task('clear:cache', [
    'cachetool:clear:opcache',
    'deploy:clear:opcache',
    'deploy:clear:cache',
]);

// Hosts
inventory('private/deployer/hosts.yml');

after('deploy:failed', 'deploy:unlock');

// Tasks
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:lock',
    'deploy:locale:prepare',
    'deploy:prepare',
    'deploy:release',
    'rsync',
    'deploy:shared',
    'deploy:writable',
    'deploy:env',
    'deploy:clear_paths',
    'deploy:migration',
    'deploy:symlink',
    'cachetool:clear:opcache',
    'deploy:clear:opcache',
    'deploy:clear:cache',
    // 'deploy:cache:warmup',
    'deploy:unlock',
    'cleanup',
    'success'
]);
