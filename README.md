# yii2-yee-translation

##Yee CMS - Translation Module

####Backend module for managing translations 

This module is part of Yee CMS (based on Yii2 Framework).

Translation module lets you easily create messages and translations on your site. 

Installation
------------

- Either run

```
composer require --prefer-dist yeesoft/yii2-yee-translation "~0.1.0"
```

or add

```
"yeesoft/yii2-yee-translation": "~0.1.0"
```

to the require section of your `composer.json` file.

- Run migrations

```php
yii migrate --migrationPath=@vendor/yeesoft/yii2-yee-translation/migrations/
```

Configuration
------
- In your backend config file

```php
'modules'=>[
	'translation' => [
		'class' => 'yeesoft\translation\TranslationModule',
	],
],
```
