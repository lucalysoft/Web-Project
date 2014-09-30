Ӧ�����
======================

Ӧ�������� [����λ��](concept-service-locator.md)��������һ���ṩ���ֲ�ͬ���ܵ� *Ӧ�����* ����������
���磬`urlManager`�����������ҳ����·�ɵ���Ӧ�Ŀ�������`db`����ṩ���ݿ���ط���ȵȡ�

��ͬһ��Ӧ���У�ÿ��Ӧ���������һ����һ�޶��� ID ������������Ӧ������������ͨ�����±��ʽ����Ӧ�������
Each application component has an ID that uniquely identifies itself among other application components
in the same application. You can access an application component through the expression

```php
\Yii::$app->componentID
```

���磬����ʹ�� `\Yii::$app->db` ����ȡ����ע�ᵽӦ�õ� [[yii\db\Connection|DB connection]]��
ʹ�� `\Yii::$app->cache` ����ȡ����ע�ᵽӦ�õ� [[yii\caching\Cache|primary cache]]�� 
and `\Yii::$app->cache` to get the [[yii\caching\Cache|primary cache]] registered with the application.
For example, you can use `\Yii::$app->db` to get the [[yii\db\Connection|DB connection]],
and `\Yii::$app->cache` to get the [[yii\caching\Cache|primary cache]] registered with the application.

��һ��ʹ�����ϱ��ʽʱ��ᴴ��Ӧ�����ʵ���������ٷ��ʻ᷵�ش�ʵ���������ٴδ�����
An application component is created the first time it is accessed through the above expression. Any
further accesses will return the same component instance.

Ӧ�����������������󣬿����� [Ӧ����������](structure-applications.md#application-configurations) ���� [[yii\base\Application::components]] ���� .
���磺
Application components can be any objects. You can register them by configuring
the [[yii\base\Application::components]] property in [application configurations](structure-applications.md#application-configurations).
For example,

```php
[
    'components' => [
        // ʹ������ע�� "cache" ���
        'cache' => 'yii\caching\ApcCache',

        // ʹ����������ע�� "db" ���
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=demo',
            'username' => 'root',
            'password' => '',
        ],

        // ʹ�ú���ע��"search" ���
        'search' => function () {
            return new app\components\SolrService;
        },
    ],
]
```

> ���䣺�����ע��̫��Ӧ�������Ӧ���������ȫ�ֱ�����ʹ��̫����ܼӴ���Ժ�ά�����Ѷȡ�
  һ������¿�������Ҫʱ�ٴ������������
> Info: While you can register as many application components as you want, you should do this judiciously.
  Application components are like global variables. Using too many application components can potentially
  make your code harder to test and maintain. In many cases, you can simply create a local component
  and use it when needed.


## ����������� <a name="bootstrapping-components"></a>
## Bootstrapping Components <a name="bootstrapping-components"></a>

�����ᵽһ��Ӧ�����ֻ���ڵ�һ�η���ʱʵ��������������������û�з��ʵĻ��Ͳ�ʵ������
��ʱ������ÿ����������̶�ʵ����ĳ��������������ᱻ���ʣ�
���Խ������ID���뵽Ӧ������� [[yii\base\Application::bootstrap|bootstrap]] �����С�
As mentioned above, an application component will only be instantiated when it is being accessed the first time.
If it is not accessed at all during a request, it will not be instantiated. Sometimes, however, you may want
to instantiate an application component for every request, even if it is not explicitly accessed.
To do so, you may list its ID in the [[yii\base\Application::bootstrap|bootstrap]] property of the application.

����, ���µ�Ӧ���������ñ�֤�� `log` ���һֱ�����ء�
For example, the following application configuration makes sure the `log` component is always loaded:

```php
[
    'bootstrap' => [
        'log',
    ],
    'components' => [
        'log' => [
            // "log" ���������
        ],
    ],
]
```


## ����Ӧ����� <a name="core-application-components"></a>
## Core Application Components <a name="core-application-components"></a>

Yii ������һ��̶�ID��Ĭ�����õ� *����* ��������� [[yii\web\Application::request|request]] ��������ռ��û����󲢽��� [·��](runtime-routing.md)��
[[yii\base\Application::db|db]] ����һ������ִ�����ݿ���������ݿ����ӡ�
ͨ����Щ�����YiiӦ�������ܴ����û�����
Yii defines a set of *core* application components with fixed IDs and default configurations. For example,
the [[yii\web\Application::request|request]] component is used to collect information about
a user request and resolve it into a [route](runtime-routing.md); the [[yii\base\Application::db|db]]
component represents a database connection through which you can perform database queries.
It is with help of these core application components that Yii applications are able to handle user requests.

������Ԥ����ĺ���Ӧ������б����Ժ���ͨӦ�����һ�����ú��Զ������ǡ�
��������һ�������������ָ�����������Ļ��ͻ�ʹ��YiiĬ��ָ�����ࡣ
Below is the list of the predefined core application components. You may configure and customize them
like you do with normal application components. When you are configuring a core application component,
if you do not specify its class, the default one will be used.

* [[yii\web\AssetManager|assetManager]]: ������Դ������Դ������������ο� [������Դ](output-assets.md) һ�ڡ�
* [[yii\db\Connection|db]]: ����һ������ִ�����ݿ���������ݿ����ӣ�
  ע�����ø����ʱ����ָ������������������������ԣ���[[yii\db\Connection::dsn]]��
  ������ο� [���ݷ��ʶ���](db-dao.md) һ�ڡ�
* [[yii\base\Application::errorHandler|errorHandler]]: ���� PHP ������쳣��
  ������ο� [������](tutorial-handling-errors.md) һ�ڡ�
* [[yii\i18n\Formatter|formatter]]: ��ʽ�������ʾ���ն��û������ݣ��������ֿ���Ҫ���ָ�����
  ����ʹ�ó���ʽ��������ο� [��ʽ���������](output-formatting.md) һ�ڡ�
* [[yii\i18n\I18N|i18n]]: ֧����Ϣ����͸�ʽ����������ο� [���ʻ�](tutorial-i18n.md) һ�ڡ�
* [[yii\log\Dispatcher|log]]: ������־����������ο� [��־](tutorial-logging.md) һ�ڡ�
* [[yii\swiftmailer\Mailer|mail]]: ֧�������ʼ��ṹ�����ͣ�������ο� [�ʼ�](tutorial-mailing.md) һ�ڡ�
* [[yii\base\Application::response|response]]: �����͸��û�����Ӧ��
  ������ο� [��Ӧ](runtime-responses.md) һ�ڡ�
* [[yii\base\Application::request|request]]: ������ն��û������յ�������
  ������ο� [����](runtime-requests.md) һ�ڡ�
* [[yii\web\Session|session]]: ����Ự��Ϣ������[[yii\web\Application|Web applications]] ��ҳӦ���п��ã�
  ������ο� [Sessions (�Ự) and Cookies](runtime-sessions-cookies.md) һ�ڡ�
* [[yii\web\UrlManager|urlManager]]: ֧��URL��ַ�����ʹ�����
  ������ο� [URL ����������](runtime-url-handling.md) һ�ڡ�
* [[yii\web\User|user]]: ������֤��¼�û���Ϣ������[[yii\web\Application|Web applications]] ��ҳӦ���п��ã�
  ������ο� [��֤](security-authentication.md) һ�ڡ�
* [[yii\web\View|view]]: ֧����Ⱦ��ͼ��������ο� [Views](structure-views.md) һ�ڡ�
