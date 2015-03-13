Wechat Component For Yii2
=========================
Wechat Component  For Yii2

This extension is base on [wechat-php-sdk](https://github.com/dodgepudding/wechat-php-sdk) and used for Yii2.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist cliff363825/yii2-wechat "*"
```

or add

```
"cliff363825/yii2-wechat": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    ...
    'components' => [
        ....
        'wechat' => [
            'class' => 'cliff363825\wechat\Component',
            'config' => [
                'type'=>'common', // 微信账号类型, common 普通, qy 企业
                'token'=>'tokenaccesskey', //填写你设定的key
                'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
                'appid'=>'wxdk1234567890', //填写高级调用功能的app id, 请在微信开发模式后台查询
                'appsecret'=>'xxxxxxxxxxxxxxxxxxx' //填写高级调用功能的密钥
            ],
        ]
    ],
];
```

Use it in your code by  :

```php
$weObj = Yii::$app->wechat->getWechat(); //获取wechat对象实例
 //TODO：调用$weObj各实例方法
```

For full details on usage, see the [documentation](https://github.com/dodgepudding/wechat-php-sdk).