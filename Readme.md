symfony new my_project_directory --version="7.0.*"

composer require symfony/orm-pack
composer require --dev symfony/maker-bundle

create the databse in env
DATABASE_URL="mysql://root:@127.0.0.1:3306/s_app?serverVersion=8&charset=utf8mb4"

then run

php bin/console doctrine:database:create

then  crate an entity class for customers
php bin/console make:entity

php bin/console make:migration
php bin/console doctrine:migrations:migrate


test
