# Requirements #
  * SQL database
  * PHP 5.3 or higher
  * PHP GD & PECL/Zip extensions


# Installation instructions #

  1. Place the Yii "framework" folder in the root path (tested with Yii 1.1.10).
  1. When on linux (Debian/Ubuntu) make sure the entire server root directory is writable by the server process, use these commands:
```
sudo chown -R www-data:www-data /var/www/
```
  1. Create tables using the included "mysql.sql" file, you'll find it in the root path.
  1. Configure your webshop in /protected/config/main.php
  1. Login with admin/admin or set another password in /protected/components/UserIdentity.php
  1. To enable Apache mod\_rewrite (SEO URLs) on linux (Debian/Ubuntu), use these commands:
```
sudo /usr/sbin/a2enmod rewrite
```
Edit the file /etc/apache2/sites-available/default
and replace the lines like:
```
AllowOverride None
```
to:
```
AllowOverride All
```
When on Linux i recommend the use of [Webmin](http://www.webmin.com/) to quickly access the Apache and PHP config files.

You will need to restart the Apache server for the changes take effects by this command:
```
sudo service apache2 restart
```
  * Enjoy !