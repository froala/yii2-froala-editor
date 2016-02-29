<?php

namespace froala\froalaeditor;

use yii\web\AssetBundle;

class FroalaEditorAsset extends AssetBundle
{
    public $sourcePath = '@bower/froala-wysiwyg-editor';
    public $js = [
        'js/froala_editor.min.js',
        'js/plugins/align.min.js',
        'js/plugins/char_counter.min.js',
        'js/plugins/code_beautifier.min.js',
        'js/plugins/code_view.min.js',
        'js/plugins/colors.min.js',
        'js/plugins/draggable.min.js',
        'js/plugins/emoticons.min.js',
        'js/plugins/entities.min.js',
        'js/plugins/file.min.js',
        'js/plugins/font_family.min.js',
        'js/plugins/font_size.min.js',
        'js/plugins/fullscreen.min.js',
        'js/plugins/image.min.js',
        'js/plugins/image_manager.min.js',
        'js/plugins/inline_style.min.js',
        'js/plugins/line_breaker.min.js',
        'js/plugins/link.min.js',
        'js/plugins/lists.min.js',
        'js/plugins/paragraph_format.min.js',
        'js/plugins/paragraph_style.min.js',
        'js/plugins/quick_insert.min.js',
        'js/plugins/quote.min.js',
        'js/plugins/save.min.js',
        'js/plugins/table.min.js',
        'js/plugins/url.min.js',
        'js/plugins/video.min.js'
    ];
    public $css = [
        'css/froala_editor.min.css',
        'css/froala_style.min.css',
        'css/plugins/char_counter.min.css',
        'css/plugins/code_view.min.css',
        'css/plugins/colors.min.css',
        'css/plugins/draggable.min.css',
        'css/plugins/emoticons.min.css',
        'css/plugins/file.min.css',
        'css/plugins/fullscreen.min.css',
        'css/plugins/image_manager.min.css',
        'css/plugins/image.min.css',
        'css/plugins/line_breaker.min.css',
        'css/plugins/quick_insert.min.css',
        'css/plugins/table.min.css',
        'css/plugins/video.min.css'
    ];

}
