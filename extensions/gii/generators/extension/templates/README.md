<?= $generator->title ?>
===

<?= $generator->description ?>


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist <?= $generator->vendorName ?>/yii2-<?= $generator->packageName ?> "*"
```

or add

```
"<?= $generator->vendorName ?>/yii2-<?= $generator->packageName ?>": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= "<?= \\{$generator->namespace}\\AutoloadExample::wiget(); ?>" ?>
];
```