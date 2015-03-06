��չ
==========

��չ�ǿ��ٷ��е��������ר���������YiiӦ���У������п���ʱ���õ��ص㡣���磬
��Ӧ�õ�ÿ��ҳ��ײ�Ϊ [yiisoft/yii2-debug](tool-debugger.md) ��չ����һ��������ԵĹ�����
���ʹ�����������������Щҳ����������ɵġ������������չģ����������Ŀ���������Ҳ���Խ�����������չ�ļ���ʽ��
���������˹�����Ĺ����ɹ�.

> ��ʾ��Ϣ: ���������� "extension" ����ָ Yii �ض��������������Щ���� Yii ����ʹ�õ�ͨ�������
  ���ǻ��á������򡱿⡱��������������ʾ���ǡ�


## ������չ <a name="using-extensions"></a>

Ϊ��ʹ����չ����������Ҫ��װ�����󲿷���չ�ļ����� [Composer](https://getcomposer.org/)
��������Composer �����������������򵥵Ĳ��谲װ��

1. �Ƴ���Ӧ���е� `composer.json` �ļ�����ָ����Ҫ��װ����չ�ļ� (Composer packages)��
2. ���� `composer install` ����װָ������չ�ļ���

��ʾ�����û�еĻ�����Ҫ��װ [Composer](https://getcomposer.org/)��

Ĭ������£�Composer ��װ��ע���� [Packagist](https://packagist.org/) - ���Ŀ�Դ
Composer ���⡣����Զ����ſ�һ�� Packagist ��չ��You may also
[create your own repository](https://getcomposer.org/doc/05-repositories.md#repository) and configure Composer
to use it. This is useful if you are developing closed open extensions and want to share within your projects.

Extensions installed by Composer are stored in the `BasePath/vendor` directory, where `BasePath` refers to the
application's [base path](structure-applications.md#basePath).  Because Composer is a dependency manager, ���
��װһ������ҲҪ��װ�����еĸ�������

���磬Ϊ�˰�װ `yiisoft/yii2-imagine` ��չ�������·�ʽ�޸� `composer.json` �ļ���

```json
{
    // ...

    "require": {
        // ... other dependencies

        "yiisoft/yii2-imagine": "*"
    }
}
```

��װ��ɺ���Ҫ�鿴 `BasePath/vendor` �µ� `yiisoft/yii2-imagine` Ŀ¼��ͬʱ��Ҫ�鿴
������װ�������� `imagine/imagine` Ŀ¼��

> ��ʾ��Ϣ��`yiisoft/yii2-imagine` ���� Yii �Ŷӿ�����ά����һ��������չ��All
  core extensions are hosted on [Packagist](https://packagist.org/) and named like `yiisoft/yii2-xyz`, where `xyz`
  varies for different extensions.

Now you can use the installed extensions like they are part of your application. ���������չʾ��
��������� `yiisoft/yii2-imagine` ��չ�ṩ�� `yii\imagine\Image` �ࣺ

```php
use Yii;
use yii\imagine\Image;

// generate a thumbnail image
Image::thumbnail('@webroot/img/test-image.jpg', 120, 120)
    ->save(Yii::getAlias('@runtime/thumb-test-image.jpg'), ['quality' => 50]);
```

> ��ʾ��Ϣ����չ���� [Yii class autoloader](concept-autoloading.md) �Զ����ء�


### �ֶ���װ��չ <a name="installing-extensions-manually"></a>

ĳЩ��������£�������Ҫ�ֶ���װ���ֻ�ȫ����չ������������ Composer��
��������

1. ������չ�浵�ļ�����ѹ�� `vendor` Ŀ¼��
2. ����еĻ�����װ����չ�ṩ�����Զ���������
3. ���ز�����˵����װ���������չ�ļ���

���һ����չû��һ���Զ�������൫����ѭ [PSR-4 standard](http://www.php-fig.org/psr/psr-4/),
�������yii�ṩ���Զ�������ȥ���������չ�ࡣAll you need to do is just to
declare a [root alias](concept-aliases.md#defining-aliases) for the extension root directory. For example,
assuming you have installed an extension in the directory `vendor/mycompany/myext`, and the extension classes
are under the `myext` namespace, then you can include the following code in your application configuration:

```php
[
    'aliases' => [
        '@myext' => '@vendor/mycompany/myext',
    ],
]
```


## ������չ <a name="creating-extensions"></a>

�������ͱ��˹����Լ��Ĵ��룬���Կ��Ǵ���һ����չ��
�����չ�ܹ������κδ��룬����һ�������࣬a widget, a module, etc.

It is recommended that you create an extension in terms of a [Composer package](https://getcomposer.org/) so that
it can be more easily installed and used by other users, liked described in the last subsection.

�����±߲���Ϊ Composer ������һ����չ��

1. Create a project for your extension and host it on a VCS repository, such as [github.com](https://github.com).
   The development and maintenance work about the extension should be done on this repository.
2. Under the root directory of the project, create a file named `composer.json` as required by Composer. Please
   refer to the next subsection for more details.
3. Register your extension with a Composer repository, such as [Packagist](https://packagist.org/), so that
   other users can find and install your extension using Composer.


### `composer.json` <a name="composer-json"></a>

ÿһ�� Composer package �ĸ�Ŀ¼�����������һ�� `composer.json` �ļ���The file contains the metadata about
the package. ������ [Composer Manual](https://getcomposer.org/doc/01-basic-usage.md#composer-json-project-setup) �ֲ����ҵ��йظ��ļ�������˵����
�±�����չʾ�� `composer.json` �ļ��� `yiisoft/yii2-imagine` ��չ��

```json
{
    // package name
    "name": "yiisoft/yii2-imagine",

    // package type
    "type": "yii2-extension",

    "description": "The Imagine integration for the Yii framework",
    "keywords": ["yii2", "imagine", "image", "helper"],
    "license": "BSD-3-Clause",
    "support": {
        "issues": "https://github.com/yiisoft/yii2/issues?labels=ext%3Aimagine",
        "forum": "http://www.yiiframework.com/forum/",
        "wiki": "http://www.yiiframework.com/wiki/",
        "irc": "irc://irc.freenode.net/yii",
        "source": "https://github.com/yiisoft/yii2"
    },
    "authors": [
        {
            "name": "Antonio Ramirez",
            "email": "amigo.cobos@gmail.com"
        }
    ],

    // package dependencies
    "require": {
        "yiisoft/yii2": "*",
        "imagine/imagine": "v0.5.0"
    },

    // class autoloading specs
    "autoload": {
        "psr-4": {
            "yii\\imagine\\": ""
        }
    }
}
```


#### Package Name <a name="package-name"></a>

ÿһ�� Composer ���������ж���Ҫ����һ��Ψһ��ʶ���Ա�����ʶ��
The format of package names is `vendorName/projectName`. ���磬in the package name `yiisoft/yii2-imagine`,
the vendor name and the project name are `yiisoft` and `yii2-imagine`, respectively.

Do NOT use `yiisoft` as vendor name as it is reserved for use by the Yii core code.

We recommend you prefix `yii2-` to the project name for packages representing Yii 2 extensions, for example,
`myname/yii2-mywidget`. This will allow users to more easily tell whether a package is a Yii 2 extension.


#### Package Type <a name="package-type"></a>

It is important that you specify the package type of your extension as `yii2-extension` so that the package can
be recognized as a Yii extension when being installed.

���û����� `composer install` ����װ��չ��`vendor/yiisoft/extensions.php`�ļ�
�����Զ����£�����������չ��������ļ��У�����֪�� Yii Ӧ��
��װ����Щ��չ (the information can be accessed via [[yii\base\Application::extensions]].


#### Dependencies <a name="dependencies"></a>

������չ������ Yii (of course)��So you should list it (`yiisoft/yii2`) in the `require` entry in `composer.json`.
���������չ������������չ���ߵ������⣬��ҲҪ���������г�����
Make sure you also list appropriate version constraints (e.g. `1.*`, `@stable`) for each dependent package. Use stable
dependencies when your extension is released in a stable version.

Most JavaScript/CSS packages are managed using [Bower](http://bower.io/) and/or [NPM](https://www.npmjs.org/),
instead of Composer. Yii uses the [Composer asset plugin](https://github.com/francoispluchino/composer-asset-plugin)
to enable managing these kinds of packages through Composer. If your extension depends on a Bower package, you can
simply list the dependency in `composer.json` like the following:

```json
{
    // package dependencies
    "require": {
        "bower-asset/jquery": ">=1.11.*"
    }
}
```

����Ĵ�����ָ������չ������ `jquery` Bower package��һ����˵��you can use
`bower-asset/PackageName` to refer to a Bower package in `composer.json`, and use `npm-asset/PackageName`
to refer to a NPM package. When Composer installs a Bower or NPM package, by default the package content will be
installed under the `@vendor/bower/PackageName` and `@vendor/npm/Packages` directories, respectively.
These two directories can also be referred to using the shorter aliases `@bower/PackageName` and `@npm/PackageName`.

���������Դ�����ϸ�ڣ���ο� [Assets](structure-assets.md#bower-npm-assets) ���֡�


#### Class Autoloading <a name="class-autoloading"></a>

In order for your classes to be autoloaded by the Yii class autoloader or the Composer class autoloader,
you should specify the `autoload` entry in the `composer.json` file, ���£�

```json
{
    // ....

    "autoload": {
        "psr-4": {
            "yii\\imagine\\": ""
        }
    }
}
```

You may list one or multiple root namespaces and their corresponding file paths.

����һ��Ӧ���а�װһ����չʱ��Yii will create for each listed root namespace
an [alias](concept-aliases.md#extension-aliases) that refers to the directory corresponding to the namespace.
���磬the above `autoload` declaration will correspond to an alias named `@yii/imagine`.


### Recommended Practices <a name="recommended-practices"></a>

Because extensions are meant to be used by other people, you often need to take extra development effort. Below
we introduce some common and recommended practices in creating high quality extensions.


#### �����ռ� <a name="namespaces"></a>

Ϊ�˱������ֳ�ͻ��ʹ����չ��������Զ����أ�you should use namespaces and
name the classes in your extension by following the [PSR-4 standard](http://www.php-fig.org/psr/psr-4/) or
[PSR-0 standard](http://www.php-fig.org/psr/psr-0/).

You class namespaces should start with `vendorName\extensionName`, where `extensionName` is similar to the project name
in the package name except that it should not contain the `yii2-` prefix. For example, for the `yiisoft/yii2-imagine`
extension, we use `yii\imagine` as the namespace its classes.

��Ҫ�� `yii`, `yii2` or `yiisoft` ��Ϊ vendor ���ơ���Щ�����Ǳ����� Yii ���Ĵ���ʹ�õġ�


#### Bootstrapping Classes <a name="bootstrapping-classes"></a>

ĳЩʱ��you may want your extension to execute some code during the [bootstrapping process](runtime-bootstrapping.md)
stage of an application. ���磬your extension may want to respond to the application's `beginRequest` event
to adjust some environment settings. While you can instruct users of the extension to explicitly attach your event
handler in the extension to the `beginRequest` event, ����ܹ�����������Զ�����

Ϊ��ʵ����һĿ�꣬you can create a so-called *bootstrapping class* by implementing [[yii\base\BootstrapInterface]].
���磬

```php
namespace myname\mywidget;

use yii\base\BootstrapInterface;
use yii\base\Application;

class MyBootstrapClass implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
             // do something here
        });
    }
}
```

You then list this class in the `composer.json` file of your extension like follows,

```json
{
    // ...

    "extra": {
        "bootstrap": "myname\\mywidget\\MyBootstrapClass"
    }
}
```

����һ��Ӧ���а�װһ����չʱ��Yii will automatically instantiate the bootstrapping class
and call its [[yii\base\BootstrapInterface::bootstrap()|bootstrap()]] method during the bootstrapping process for
every request.


#### Working with Databases <a name="working-with-databases"></a>

�����չ������Ҫ�������ݿ⡣Do not assume that the applications that use your extension will always
use `Yii::$db` as the DB connection. ������you should declare a `db` property for the classes that require DB access.
The property will allow users of your extension to customize which DB connection they would like your extension to use.
�ٸ����ӣ�you may refer to the [[yii\caching\DbCache]] class and see how it declares and uses the `db` property.

��������չ��Ҫ����һ����ϸ�� DB tables ���� Ҫ�ı� DB schema����Ҫ

- �ṩ [migrations](db-migrations.md) ���ٿ� DB schema��������ʹ����ͨ�� SQL �ļ���
- ������Ǩ���ܹ���Ӧ��ͬ�� DBMS��
- ����ʹ�� migrations �е� [Active Record](db-active-record.md)��


#### Using Assets <a name="using-assets"></a>

��������չ�� a widget ���� a module��chances are that it may require some [assets](structure-assets.md) to work.
���磬���ܻ���ʾһЩ���� images, JavaScript, and CSS ��ҳ�档Because the files of an
extension are all under the same directory which is not Web accessible when installed in an application, you have
two choices to make the asset files directly accessible via Web:

- ask users of the extension to manually copy the asset files to a specific Web-accessible folder;
- declare an [asset bundle](structure-assets.md) and rely on the asset publishing mechanism to automatically
  copy the files listed in the asset bundle to a Web-accessible folder.

We recommend you use the second approach so that your extension can be more easily used by other people.
Please refer to the [Assets](structure-assets.md) section for more details about how to work with assets in general.


#### Internationalization and Localization <a name="i18n-l10n"></a>

Your extension may be used by applications supporting different languages! ��ˣ�if your extension displays
content to end users, you should try to [internationalize and localize](tutorial-i18n.md) it. In particular,

- If the extension displays messages intended for end users, the messages should be wrapped into `Yii::t()`
  so that they can be translated. Messages meant for developers (such as internal exception messages) do not need
  to be translated.
- If the extension displays numbers, dates, etc., they should be formatted using [[yii\i18n\Formatter]] with
  appropriate formatting rules.

�˽����ϸ�ڣ���ο� [Internationalization](tutorial-i18n.md) ���ֵ����ݡ�


#### ���� <a name="testing"></a>

�������Ҫ�������չû�к��֮�ǵ��������С�Ϊ�˴ﵽ���Ŀ�ģ���Ӧ��
�ڷ�����չǰ�Ȳ�������

It is recommended that you create various test cases to cover your extension code rather than relying on manual tests.
ÿ�����㷢���°汾����չ֮ǰ����Ӧ�ü򵥵�������Щ���԰���
everything is in good shape. Yii �ṩ�˲���֧�֣����԰��������д��Ԫ���ԣ�
���ղ��Ժ͹��ܲ��ԡ�������ϸ���ݣ���ο� [Testing](test-overview.md) ���֡�


#### Versioning <a name="versioning"></a>

��Ӧ�ø�ÿ����չ�ķ�������һ���汾�� (e.g. `1.0.1`)��We recommend you follow the
[semantic versioning](http://semver.org) practice when determining what version numbers should be used.


#### Releasing <a name="releasing"></a>

Ϊ����������֪����İ汾������Ҫ������֮���ڡ�

����������һ�η���һ����չ����Ӧ������ Composer ����ע�ᣬ����
[Packagist](https://packagist.org/)�� After that, all you need to do is simply creating a release tag (e.g. `v1.0.1`)
on the VCS repository of your extension and notify the Composer repository about the new release. People will
then be able to find the new release, and install or update the extension through the Composer repository.

������չ�İ汾�У����˴����ļ����㻹��Ҫע�����¼���
�������������˽��ʹ�������չ��

* �ڰ���Ŀ¼��� readme �ļ����������������չ�����Լ���ΰ�װ��ʹ��.
  We recommend you write it in [Markdown](http://daringfireball.net/projects/markdown/) format and name the file
  as `readme.md`.
* �ڰ���Ŀ¼�и�����־�ļ������г���ÿ���汾�����ı仯���ļ�
  ���Ա�д�� Markdown ��ʽ������Ϊ `changelog.md`��
* �ڰ���Ŀ¼�������ļ������ṩ���й���δӾɰ汾����
  ��˵�������ļ����Ա�д�� Markdown ��ʽ������Ϊ `upgrade.md`��
* �̳̣�demos, screenshots, etc.: these are needed if your extension provides many features that cannot be
  fully covered in the readme file.
* API documentation:��Ĵ���Ӧ�úúõؼ�¼������
  ����Բο� [Object class file](https://github.com/yiisoft/yii2/blob/master/framework/base/Object.php)
  ��ѧϰ��μ�¼���롣

> ��ʾ��Ϣ��������е�ע�Ϳ���д�� Markdown ��ʽ��`yiisoft/yii2-apidoc` ��չΪ���ṩ��һ
  �����ڴ���ע�����ɵ����� API �ĵ����ߡ�

> ��ʾ��Ϣ����Ȼ���Ǳ���ģ������Խ������Ӧ����ͳһ�Ĵ����񡣿���
  �ο� [core framework code style](https://github.com/yiisoft/yii2/wiki/Core-framework-code-style)��


## Core Extensions <a name="core-extensions"></a>

Yii �ṩ�����º�����չ����Щ��չ���� Yii �����Ŷ�ά���Ϳ��������Ƕ�����
[Packagist](https://packagist.org/) ע��Ĳ��ҿ��Ժ����׵ı���װ��
[Using Extensions](#using-extensions) �����С�

- [yiisoft/yii2-apidoc](https://github.com/yiisoft/yii2-apidoc):
  �ṩһ������չ�����Ǹ����ܵ� API �ĵ���������It is also used to generate the core
  framework API documentation.
- [yiisoft/yii2-authclient](https://github.com/yiisoft/yii2-authclient):
  provides a set of commonly used auth clients, such as Facebook OAuth2 client, GitHub OAuth2 client.
- [yiisoft/yii2-bootstrap](https://github.com/yiisoft/yii2-bootstrap):
  provides a set of widgets that encapsulate the [Bootstrap](http://getbootstrap.com/) components and plugins.
- [yiisoft/yii2-codeception](https://github.com/yiisoft/yii2-codeception):
  provides testing support based on [Codeception](http://codeception.com/).
- [yiisoft/yii2-debug](https://github.com/yiisoft/yii2-debug):
  provides debugging support for Yii applications. When this extension is used, a debugger toolbar will appear
  at the bottom of every page. The extension also provides a set of standalone pages to display more detailed
  debug information.
- [yiisoft/yii2-elasticsearch](https://github.com/yiisoft/yii2-elasticsearch):
  provides the support for using [Elasticsearch](http://www.elasticsearch.org/). It includes basic querying/search
  support and also implements the [Active Record](db-active-record.md) pattern that allows you to store active records
  in Elasticsearch.
- [yiisoft/yii2-faker](https://github.com/yiisoft/yii2-faker):
  provides the support for using [Faker](https://github.com/fzaninotto/Faker) to generate fake data for you.
- [yiisoft/yii2-gii](https://github.com/yiisoft/yii2-gii):
  provides a Web-based code generator that is highly extensible and can be used to quickly generate models,
  forms, modules, CRUD, etc.
- [yiisoft/yii2-imagine](https://github.com/yiisoft/yii2-imagine):
  provides commonly used image manipulation functions based on [Imagine](http://imagine.readthedocs.org/).
- [yiisoft/yii2-jui](https://github.com/yiisoft/yii2-jui):
  provides a set of widgets that encapsulate the [JQuery UI](http://jqueryui.com/) interactions and widgets.
- [yiisoft/yii2-mongodb](https://github.com/yiisoft/yii2-mongodb):
  provides the support for using [MongoDB](http://www.mongodb.org/). It includes features such as basic query,
  Active Record, migrations, caching, code generation, etc.
- [yiisoft/yii2-redis](https://github.com/yiisoft/yii2-redis):
  provides the support for using [redis](http://redis.io/). It includes features such as basic query,
  Active Record, caching, etc.
- [yiisoft/yii2-smarty](https://github.com/yiisoft/yii2-smarty):
  provides a template engine based on [Smarty](http://www.smarty.net/).
- [yiisoft/yii2-sphinx](https://github.com/yiisoft/yii2-sphinx):
  provides the support for using [Sphinx](http://sphinxsearch.com). It includes features such as basic query,
  Active Record, code generation, etc.
- [yiisoft/yii2-swiftmailer](https://github.com/yiisoft/yii2-swiftmailer):
  provides email sending features based on [swiftmailer](http://swiftmailer.org/).
- [yiisoft/yii2-twig](https://github.com/yiisoft/yii2-twig):
  provides a template engine based on [Twig](http://twig.sensiolabs.org/).
