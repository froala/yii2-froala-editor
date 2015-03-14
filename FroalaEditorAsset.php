<?php

namespace dungphanxuan\froalaeditor;

use yii\web\AssetBundle;

class FroalaEditorAsset extends AssetBundle
{
    public $sourcePath = '@dungphanxuan/froalaeditor/assets';
    public $js = [
        'js/froala_editor.min.js',
        'js/plugins/tables.min.js',
        'js/plugins/lists.min.js',
        'js/plugins/colors.min.js',
        'js/plugins/media_manager.min.js',
        'js/plugins/font_family.min.js',
        'js/plugins/font_size.min.js',
        'js/plugins/video.min.js',
    ];
    public $css = [
        'css/froala_editor.min.css',
        'css/froala_style.min.css',
        'css/font-awesome.min.css',
    ];

}
