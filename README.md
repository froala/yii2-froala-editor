# Yii Framework Froala WYSIWYG HTML Editor

[![Packagist](https://img.shields.io/packagist/v/froala/yii2-froala-editor.svg)](https://packagist.org/packages/froala/yii2-froala-editor)
[![Packagist](https://img.shields.io/packagist/dt/froala/yii2-froala-editor.svg)](https://packagist.org/packages/froala/yii2-froala-editor)

>Yii 2 widget for Froala Wysiwyg editor.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). yii2-froala editor depends on Froala PHP SDK
To use and Install the editor, one must install PHP SDK also.

Either run

```
php composer.phar require --prefer-dist froala/yii2-froala-editor
php composer.phar require --prefer-dist froala/wysiwyg-editor-php-sdk
php composer.phar require --prefer-dist bower-asset/froala-wysiwyg-editor

```

or add

```
"froala/yii2-froala-editor": "^2.6.0",
"froala/wysiwyg-editor-php-sdk" : "*",
"bower-asset/froala-wysiwyg-editor": "^2.6.0"

```

to the require section of your `composer.json` file.


## Usage

Once the extension is installed, simply use it in your code by  :

```php
<?php echo froala\froalaeditor\FroalaEditorWidget::widget([
    'name' => 'content',
    'options' => [
        // html attributes
        'id'=>'content'
    ],
    'clientOptions' => [
        'toolbarInline'=> false,
        'theme' =>'royal', //optional: dark, red, gray, royal
        'language'=>'en_gb' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
    ]
]); ?>
```

or use with a model:

```php
<?php echo froala\froalaeditor\FroalaEditorWidget::widget([
    'model' => $model,
    'attribute' => 'content',
    'options' => [
        // html attributes
        'id'=>'content'
    ],
    'clientOptions' => [
        'toolbarInline' => false,
        'theme' => 'royal', //optional: dark, red, gray, royal
        'language' => 'en_gb' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
    ]
]); ?>
```

## Upload example

Using the Froala PHP SDK with Froala Editor widget, the first step would be to add the configuration in web.php config file, make an entry for Froala Module
in the Config Array.

```php
'modules' => [
        'froala' => [
            'class' => '\froala\froalaeditor\Module',
            'uploadFolder' => '/uploads/'
        ]
    ],
```

Make sure you have a folder called "uploads" in your web root directory,Now to use the Froala Widget on any view just use the following code in the view:

```php
<?= \froala\froalaeditor\FroalaEditorWidget::widget([
    'name' => 'body',
    'clientOptions' => [
        'toolbarInline'=> false,
        'height' => 200,
        'theme' => 'royal',//optional: dark, red, gray, royal
        'language' => 'en_gb' ,
        'toolbarButtons' => ['fullscreen', 'bold', 'italic', 'underline', '|', 'paragraphFormat', 'insertImage'],
        'imageUploadParam' => 'file'
    ],
    'clientPlugins'=> ['fullscreen', 'paragraph_format', 'image']
]); ?>
```

For full details on usage, see the [documentation](https://froala.com/wysiwyg-editor/docs).

## License

This package is available under MIT License. However, Froala editor requires purchasing a license from https://www.froala.com/wysiwyg-editor/pricing.
