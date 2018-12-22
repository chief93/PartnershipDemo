# Partnership example projects

This is a repository for implementations of partnership program application. Examples are made within `Quark` and `Laravel`

The scope of this repository is to demonstrate the difference between two different frameworks, saving the notes for myself for using of Laravel (many unobvious configuration things need to be placed somewhere) and demonstrating an up-to-dated example of `Quark`-based application, adjusted to the last stable `Quark` version.

Both project can work with same database simultaneously. You can use the `partnership.sql` to restore the database structure.

### Quark-based

#### Requirements
 - [Quark](https://github.com/Qybercom/quark)
 - MySQL (5.5+)
 - PHP (5.4+)

#### Installation
 1. Clone (or download `.zip` archive) of Quark
 2. Rename `loader-example.php` in `loader.php`
 3. Put the path to `Quark.php` in `loader.php`
 4. Create a `./runtime` directory in the project root
 5. Rename `application-example.ini` in `application.ini` and move it in `./runtime` directory
 6. Adjust the settings in the `./runtime/application.ini` to your environment:
    - Set an appropriate WebHost (FQDN) for project
    - Set database connection URI
 7. Enjoy!

### Laravel-based

#### Requirements
 - [Laravel](https://laravel.com) (5.7+)
 - MySQL (5.5+)
 - PHP (7.1+)
 - Composer

#### Installation
 1. `composer install`
 2. Adjust application settings in `./.env` file
 > *2.1. Optional: If you haven't used the `partnership.sql` for restoring the database structure, you can use the provided migrations*
 3. Enjoy!