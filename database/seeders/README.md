# Seeders

There are 3 types of seeder folder:
1. InitSeeders
	- PatchSeeders
1. FakeSeeders

## InitSeeders

Provide the necessary data for the application to run smoothly for new cloned environment.

```sh
# migrate & all seed in DatabaseSeeder.php
php artisan migrate:seed

# seed specific seeder
php artisan db:seed --class="Database\Seeders\InitSeeders\SomeSeeder"
```

## FakeSeeders

Provide data for testing when development.
Works with factory & faker.

## PatchSeeders

Provide the necessary add-on data without reset the existing seeder in `#initSeeders` when new patch is released.

```sh
# seed specific patchSeeder
php artisan db:seed --class="Database\Seeders\InitSeeders\Patch\Version_YYYY_MM_DD\IndexSeeder"
```

* ps: data in PatchSeeders required to sync back to InitSeeders