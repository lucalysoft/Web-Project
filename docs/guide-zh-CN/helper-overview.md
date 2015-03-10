Helpers
=======

> ע�⣺�ⲿ�����ڿ����С�

Yii �ṩ��������򻯳������룬���������������Ĳ�����
HTML �������ɣ��ȵȡ���Щ�����౻��д�������ռ� `yii\helpers` �£�����
ȫ�Ǿ�̬�� ������˵����ֻ������̬���Ժ;�̬���������Ҳ���ʵ��������

����ͨ����������һ����̬������ʹ�������࣬���£�

```php
use yii\helpers\Html;

echo Html::encode('Test > test');
```

> ע�⣺Ϊ��֧�� [customizing helper classes](#customizing-helper-classes)��Yii ��ÿһ��������
  �ָ��������ࣺһ������ (e.g. `BaseArrayHelper`) ��һ�� concrete �� (e.g. `ArrayHelper`).
  ��ʹ��������ʱ��Ӧ�ý�ʹ�� concrete ��汾����ʹ�û��ࡣ


Core Helper Classes
-------------------

Yii ���������ṩ���º��������ࣺ

- [ArrayHelper](helper-array.md)
- Console
- FileHelper
- [Html](helper-html.md)
- HtmlPurifier
- Image
- Inflector
- Json
- Markdown
- Security
- StringHelper
- [Url](helper-url.md)
- VarDumper


Customizing Helper Classes <span id="customizing-helper-classes"></span>
--------------------------

To customize a core helper class (e.g. [[yii\helpers\ArrayHelper]]), you should create a new class extending
from the helpers corresponding base class (e.g. [[yii\helpers\BaseArrayHelper]]) and name your class the same
as the corresponding concrete class (e.g. [[yii\helpers\ArrayHelper]]), �������������ռ䡣This class
will then be set up to replace the original implementation of the framework.

����ʾ����ʾ������Զ��� [[yii\helpers\ArrayHelper]] ���
[[yii\helpers\ArrayHelper::merge()|merge()]] ������

```php
<?php

namespace yii\helpers;

class ArrayHelper extends BaseArrayHelper
{
    public static function merge($a, $b)
    {
        // your custom implementation
    }
}
```

������ౣ����һ����Ϊ `ArrayHelper.php` ���ļ��С����ļ��������κ�Ŀ¼������ `@app/components`��

Next, in your application's [entry script](structure-entry-scripts.md), add the following line of code
after including the `yii.php` file to tell the [Yii class autoloader](concept-autoloading.md) to load your custom
class instead of the original helper class from the framework:

```php
Yii::$classMap['yii\helpers\ArrayHelper'] = '@app/components/ArrayHelper.php';
```

Note that customizing of helper classes is only useful if you want to change the behavior of an existing function
of the helpers. �������Ϊ���Ӧ�ó�����Ӹ��ӹ��ܣ����Ϊ������һ��������
�����ࡣ
