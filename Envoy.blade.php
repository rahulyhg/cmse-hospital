@servers(['production'=>'root@cmse.com.my'])

<?php
$repo = 'git@github.com-cmse-hospital:warrence/cmse-hospital.git';
$release_dir = '/var/www/html/frontend/releases';
$env = '/var/www/html/frontend/.env';
$app_dir = '/var/www/html/frontend/cmse-hospital';
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
chmod 777 {{ $release_dir }}/{{ $release }}/vendor -R
chmod 777 {{ $release_dir }}/{{ $release }}/storage -R

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