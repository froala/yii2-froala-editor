Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist froala/yii2-froala-editor "*"
```

or add

```
"froala/yii2-froala-editor": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php echo dungphanxuan\froalaeditor\FroalaEditorWidget::widget([
    'name' => 'content',
    'options'=>[// html attributes
        'id'=>'content'
    ],
    'clientOptions'=>[
        'inlineMode'=> false,
        'theme' =>'royal',//optional: dark, red, gray, royal
        'language'=>'en_us' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
    ]
]);; ?>
```

or use with a model:

```php
<?php echo dungphanxuan\froalaeditor\FroalaEditorWidget::widget([
    'model' => $model,
    'attribute' => 'content',
    'options'=>[// html attributes
        'id'=>'content'
    ],
    'clientOptions'=>[
        'inlineMode'=> false,
        'theme' =>'royal',//optional: dark, red, gray, royal
        'language'=>'en_us' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
    ]
]);; ?>
```

For full details on usage, see the [documentation](https://editor.froala.com/docs).

License
----

This package is available under MIT License. However, Froala editor is free only for non-commercial projects. For commercial applications see http://editor.froala.com/pricing for licensing.
