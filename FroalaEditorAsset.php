<?php

namespace froala\froalaeditor;

use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

class FroalaEditorAsset extends AssetBundle
{
    public $sourcePath = '@bower/froala-wysiwyg-editor';
    public $froalaPlugins = [
        'align', 'char_counter', 'code_beautifier', 'code_view', 'colors',
        'draggable', 'emoticons', 'entities', 'file', 'font_family',
        'font_size', 'fullscreen', 'image', 'image_manager', 'inline_style',
        'line_breaker', 'link', 'lists', 'paragraph_format', 'paragraph_style',
        'quick_insert', 'quote', 'save', 'table', 'url', 'video',
    ];
    public $js = [
        'js/froala_editor.min.js',
    ];
    public $css = [
        'css/froala_editor.min.css',
        'css/froala_style.min.css',
    ];
    public $depends = [
        // use depends instead of direct CDNs
        '\yii\web\JqueryAsset',
        '\rmrevin\yii\fontawesome\AssetBundle',
    ];
    /**
     * @var $clientPlugins array leave empty to load all plugins
     * <pre>sample input:
     * [
     *      //specify only needed forala plugins (local files)
     *      'url',
     *      'align',
     *      'char_counter',
     *       ...
     *      //override default files for a specific plugin
     *      'table' => [
     *              'css' => '<new css file url>'
     *          ],
     *      //include custom plugin
     *      'my_plugin' => [
     *              'js' => '<js file url>' // required
     *              'css' => '<css file url>' // optional
     *          ],
     *      ...
     * ]
     */
    static public $clientPlugins;

    /**
     * @var $excludedPlugins array list of plugin names to be excluded
     */
    static public $excludedPlugins;

    /**
     * @var $froalaBowerPath string path to library folder 'froala-wysiwyg-editor'
     */
    public $froalaBowerPath;

    public function init()
    {
        $this->froalaBowerPath = $this->froalaBowerPath ?: \Yii::getAlias('@bower/froala-wysiwyg-editor');
        if (is_array(static::$clientPlugins)) {
            if (ArrayHelper::isIndexed(static::$clientPlugins, true)) {
                // sequential array = list of plugins to be included
                // use default configurations for every plugin
                $this->registerPlugins(static::$clientPlugins);
            } else {
                // associative array = custom plugins and options included
                foreach (static::$clientPlugins as $key => $value) {
                    if (is_numeric($key)) {
                        $pluginName = $value;
                        if (!$this->isPluginExcluded($pluginName)) {
                            $this->registerPlugin($pluginName);
                        }
                    } else {
                        $pluginName = $key;
                        if (!$this->isPluginExcluded($pluginName)) {
                            $pluginOptions = $value;
                            $issetJs = isset($pluginOptions['js']);
                            $issetCss = isset($pluginOptions['css']);
                            if ($issetJs) {
                                $this->js[] = $pluginOptions['js'];
                            } else {
                                $jsFile = "js/plugins/$pluginName.min.js";
                                if (is_file($this->froalaBowerPath . '/' . $jsFile)) {
                                    $this->js[] = $jsFile;
                                } else {
                                    throw new Exception("you must set 'js' [and 'css'] for plugin '$pluginName'");
                                }
                            }
                            if ($issetCss) {
                                $this->css[] = $pluginOptions['css'];
                            }
                        }
                    }
                }
            }
        } else {
            $this->registerPlugins(array_diff($this->froalaPlugins, static::$excludedPlugins ?: []), false, true);
        }
        parent::init();
    }

    public function registerPlugin($pluginName, $checkJs = true, $checkCss = true)
    {
        $jsFile = "js/plugins/$pluginName.min.js";
        if ($checkJs || $this->isPluginJsFileExist($pluginName)) {
            $this->js[] = $jsFile;
            $cssFile = "css/plugins/$pluginName.min.css";
            if (!$checkCss || $this->isPluginCssFileExist($pluginName)) {
                $this->css[] = $cssFile;
            }
        } else {
            throw new Exception("plugin '$pluginName' is not supported, if you trying to set custom plugin, please set 'js' and 'css' for your plugin");
        }
    }

    public function registerPlugins(array $pluginsArray, $checkJs = true, $checkCss = true)
    {
        foreach ($pluginsArray as $pluginName) {
            $this->registerPlugin($pluginName, $checkJs, $checkCss);
        }
    }

    public function isPluginJsFileExist($pluginName)
    {
        return is_file("$this->froalaBowerPath/js/plugins/$pluginName.min.js");
    }

    public function isPluginCssFileExist($pluginName)
    {
        return is_file("$this->froalaBowerPath/css/plugins/$pluginName.min.css");
    }

    private function isPluginExcluded($pluginName)
    {
        return in_array($pluginName, static::$excludedPlugins);
    }
}
