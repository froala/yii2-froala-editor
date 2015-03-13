<?php

namespace dungphanxuan\froalaeditor;

use yii\web\AssetBundle;

class FroalaEditorAsset extends AssetBundle
{
    public $sourcePath = '@dungphanxuan/froalaeditor/assets';
    public $js = [
        'js/froala_editor.min.js',
        'js/froala_editor_ie8.min.js',
    ];
    public $css = [
        'css/themes/froala_editor.min.css',
        'css/themes/froala_style.min.css',
        'css/themes/font-awesome.min.css',
    ];

}
