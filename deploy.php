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

// Shared files/dirs between deploys
//add('shared_files', []);
//add('shared_dirs', []);

// Writable dirs by web server
//add('writable_dirs', []);


// Hosts

host('batterymanager')
    ->set('deploy_path', '~/httpdocs/{{application}}');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

task('wasfehlt', function () {
    run('cd {{release_path}} && composer install');
    run('cd {{release_path}} && php artisan route:clear');
    run('cd {{release_path}} && php artisan config:clear');
    run('cd {{release_path}} && php artisan cache:clear');
});

task('startMaintenanceMode', function () {
    run('cd {{release_path}} && sudo chown -R hosting145387:hosting145387 storage');
    run('cd {{release_path}} && php artisan down');
});

task('stopMaintenanceMode', function () {
    run('cd {{release_path}} && php artisan up');
    run('cd {{release_path}} && sudo chown -R www-data:www-data storage');
});

after('deploy', 'wasfehlt');
//after('deploy', 'stopMaintenanceMode');

before('deploy', 'startMaintenanceMode');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'stopMaintenanceMode');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

