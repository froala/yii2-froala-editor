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
     * @var $froalaBowerPath string path to library folder 'froala-wysiwyg-editor'
     */
    public $froalaBowerPath;

    public function init()
    {
        $this->froalaBowerPath = $this->froalaBowerPath ?: \Yii::getAlias('@bower/froala-wysiwyg-editor');
        parent::init();
    }

    public function registerClientPlugins($clientPlugins, $excludedPlugins)
    {
        if (is_array($clientPlugins)) {
            if (ArrayHelper::isIndexed($clientPlugins, true)) {
                // sequential array = list of plugins to be included
                // use default configurations for every plugin
                $this->registerPlugins($clientPlugins);
            } else {
                // associative array = custom plugins and options included
                foreach ($clientPlugins as $key => $value) {
                    if (is_numeric($key)) {
                        $pluginName = $value;
                        if (!$this->isPluginExcluded($pluginName, $excludedPlugins)) {
                            $this->registerPlugin($pluginName);
                        }
                    } else {
                        $pluginName = $key;
                        if (!$this->isPluginExcluded($pluginName, $excludedPlugins)) {
                            $pluginOptions = $value;
                            $issetJs = isset($pluginOptions['js']);
                            $issetCss = isset($pluginOptions['css']);
                            if ($issetJs) {
                                $this->addJs($pluginOptions['js']);
                            } else {
                                if ($this->isPluginJsFileExist($pluginName)) {
                                    $this->addJs($this->getDefaultJsUrl($pluginName));
                                } else {
                                    throw new Exception("you must set 'js' [and 'css'] for plugin '$pluginName'");
                                }
                            }
                            if ($issetCss) {
                                $this->addCss($pluginOptions['css']);
                            } else {
                                if ($this->isPluginCssFileExist($pluginName)) {
                                    $this->addCss($this->getDefaultCssUrl($pluginName));
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $this->registerPlugins(array_diff($this->froalaPlugins, $excludedPlugins ?: []), false, true);
        }
    }

    public function registerPlugin($pluginName, $checkJs = true, $checkCss = true)
    {
        $jsFile = "js/plugins/$pluginName.min.js";
        if ($checkJs || $this->isPluginJsFileExist($pluginName)) {
            $this->addJs($jsFile);
            $cssFile = "css/plugins/$pluginName.min.css";
            if (!$checkCss || $this->isPluginCssFileExist($pluginName)) {
                $this->addCss($cssFile);
            }
        } else {
            throw new Exception("plugin '$pluginName' is not supported, if you trying to set custom plugin, please set 'js' and 'css' options for your plugin");
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
        return is_file($this->froalaBowerPath . '/' . $this->getDefaultJsUrl($pluginName));
    }

    public function isPluginCssFileExist($pluginName)
    {
        return is_file($this->froalaBowerPath . '/' . $this->getDefaultCssUrl($pluginName));
    }

    public function isPluginExcluded($pluginName, $excludedPlugins)
    {
        return in_array($pluginName, $excludedPlugins);
    }

    public function addJs($jsFile)
    {
        $this->js[] = $jsFile;
    }

    public function addCss($cssFile)
    {
        $this->css[] = $cssFile;
    }

    public function getDefaultCssUrl($pluginName)
    {
        return "css/plugins/$pluginName.min.css";
    }

    private function getDefaultJsUrl($pluginName)
    {
        return "js/plugins/$pluginName.min.js";
    }
}
