<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'batterymanager.marcus-jochimsen');

// Project repository
set('repository', 'https://github.com/MarcusJochimsen/battery-manager.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('http_user', 'hosting145387');

set('writable_mode', 'chmod');

//set('bin/php', 'php');
//set('bin/composer', 'composer');

// Shared files/dirs between deploys
add('shared_files', ['.env']);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts
host('batterymanager')
    ->set('deploy_path', '~/httpdocs/{{application}}');

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');

