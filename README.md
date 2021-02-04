# KS Role Right Bundle
This is a simple Symfony implementation for a role and right system.
This bundle gives you a structure to create and manage roles and rights.

##The bundle contains the following
* 3 entities `User, KSRole, KSRight`
* 3 repositories `UserRepository, KSRoleRepository, KSRightRepository`
* A bin/console command to place the entities and repositories in the src folder
* Twig functions to handle `KSRole` and `KSRight` checking

##The bundle does not contain
This bundle does **not** provide controllers or views. It just provides the functionality. I might include it in the future.

##Note
This bundle uses the [Symfony Security Component](https://symfony.com/doc/current/security.html). Without it this system **won't** work.<br><br>
You can still use the `access_control` from the [Symfony Security Component](https://symfony.com/doc/current/security.html). E.g.
say you have a backend system that you only want people to access with a certain role / right. Normal users however are not logged in. You can do it like this:
```yaml
access_control:
        - { path: ^/backend/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/backend/*, roles: ROLE_USER }
```
The `User` entity from the [Symfony Security Component](https://symfony.com/doc/current/security.html) gives all logged in users the role `ROLE_USER`.<br>

You can also use your own user class. Just replace the one I provided with yours as long as it is still named `User` (don't forget to relink `KSRight` with `User`).

##Installation
**Before** you install the package create a config file `config/packages/ks_role_right.yaml`
```yaml
ks_role_right:
    app_directory: '%kernel.project_dir%'
```

Install the package with:
```console
composer require kevinsentjens/role-right-bundle
```

Set the files necessary for the system:
```console
php bin/console ks:set-files
```

Create a migration:
```console
php bin/console make:migration
```

##Usage

###Controller
To check for a certain `KSRight` in a controller:
```php
public function __construct(KSRoleRight $ksRoleRight)
{
    if (!$ksRoleRight->hasKSRight('manage-users'))
    {
        throw $this->createAccessDeniedException('You don\'t have the required permissions.');
    }
}
```
You can do this in either the controllers `__construct()` so it works for every route or you can use it in just a single function.
The `KSRole` works exactly the same way. Just replace 
```php
if (!$ksRoleRight->hasKSRight('manage-users'))
```
**with**
```php
if (!$ksRoleRight->hasKSRole('SUPER_ADMIN'))
```

###Twig view
This bundle provides 2 `Twig Functions` and 1 `Twig filter`

To check a `KSRight` you can use the function `has_right('name of right')`

To check a `KSRole` you can use the function `has_role('name of role')`

To check if a `KSRole` has a `KSRight` you can use the filter `KSRole object|roleHasRight('name of right')`

##License
This package is free software distributed under the terms of the [MIT license](LICENSE).

## Future ideas
* Create an annotation to use in controllers instead of the `KSRoleRight->hasRight('name of right')`
* Apply for Symfony recipes
* Provide controllers and views

##Updates
* Februari 4th 2021
    * Added methods in the `KSRoleRight` class to get `KSRole` and `KSRight` by name
    * Added methods in the `KSRoleRight` class to get `KSRole` and `KSRight` by id
    * Updated the ReadMe file