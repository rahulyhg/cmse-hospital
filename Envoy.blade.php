@servers(['production'=>'root@192.168.1.150'])

<?php
$repo = 'git@github.com:warrence/cmse.git';
$release_dir = '/var/www/html/backend/releases';
$env = '/var/www/html/backend/.env';
$app_dir = '/var/www/html/backend/cmse';
$release = 'release_' . date('YmdHis');
?>

@macro('deploy', ['on' => 'production'])
fetch_repo
run_composer
update_permissions
update_symlinks
database_migrate
@endmacro

@task('fetch_repo')
[ -d {{ $release_dir }} ] || mkdir {{ $release_dir }};
cd {{ $release_dir }};
git clone {{ $repo }} {{ $release }};
@endtask

@task('run_composer')
cd {{ $release_dir }}/{{ $release }};
composer install --prefer-dist;
@endtask

@task('update_permissions')
cd {{ $release_dir }};


@endtask

@task('update_symlinks')
ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }};
ln -nfs {{ $env }} {{ $app_dir }}/.env;

@endtask

@task('database_migrate')
cd {{ $app_dir }}
php artisan down
php artisan migrate --force
php artisan up
@endtask