<?php

namespace dungphanxuan\froalaeditor;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

class FroalaEditorWidget extends InputWidget
{
    const PLUGIN_NAME = 'FroalaEditor';

    /**
     * KindEditor Options
     * @var array
     */
    public $clientOptions = [];

    /**
     * csrf cookie param
     * @var string
     */
    public $csrfCookieParam = '_csrfCookie';

    /**
     * @var boolean
     */
    public $render = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->render) {
            if ($this->hasModel()) {
                echo Html::activeTextarea($this->model, $this->attribute, $this->options);
            } else {
                echo Html::textarea($this->name, $this->value, $this->options);
            }
        }
        $this->registerClientScript();
    }
    /**
     * register client scripts(css, javascript)
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        $this->initClientOptions();

        $asset = FroalaEditorAsset::register($view);
        //theme
        $themeType = isset($this->clientOptions['theme']) ? $this->clientOptions['theme'] : 'default';
        if ($themeType != 'default') {
            $view->registerCssFile($asset->baseUrl . "/css/themes/{$themeType}.css", ['depends' => '\dungphanxuan\froalaeditor\FroalaEditorAsset']);
        }
        //language
        $langType = isset($this->clientOptions['language']) ? $this->clientOptions['language'] : 'en_us';
        if ($langType != 'es_us') {
            $view->registerJsFile($asset->baseUrl . "/js/langs/{$langType}.js", ['depends' => '\dungphanxuan\froalaeditor\FroalaEditorAsset']);
        }

        $options = empty($this->options) ? '' : Json::encode($this->options);
        $id = $this->options['id'];

        $this->updateAsset();
        $view ->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js');
        $view ->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css');
        $varName = self::PLUGIN_NAME . '_' . str_replace('-', '_', $id);
        $js = "
         $('#".$id ."').editable(
             " . Json::encode($this->clientOptions) . "
         );
        ";
        $view->registerJs($js);
    }
    /*
     *
     * */
    public function updateAsset(){
//Replace jquery 2
        Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = [
            'sourcePath' => null,
            'js' => ['jquery.js' => 'http://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js'],
        ];
    }
    /**
     * client options init
     */
    protected function initClientOptions()
    {
        // KindEditor optional parameters
        $params = [
            'inlineMode',
            'countCharacters',
            'alwaysVisible',
            'initOnClick',
            'editInPopup',
            'toolbarFixed',
            'paragraphy',
            'plainPaste',
            'placeholder',
            'maxCharacters',
            'minHeight',
            'maxHeight',
            'direction',
            'colors',
            'colorsStep',
            'shortcuts',
            'shortcutsAvailable',
            'tabSpaces',
            'inlineStyles',
            'imageUploadParam',
            'imageUploadURL',
            'fileUploadParam',
            'fileUploadParams',
            'fileUploadURL',
            'preloaderSrc',
            'imagesLoadURL',
            'imagesLoadParams',
            'imageDeleteParams',
            'saveRequestType',
            'saveParams',
            'saveURL',
            'autosave',
            'buttons',
            'height',
            'theme',
            'language',
        ];
        $options = [];
        $options['height'] = '80px';
        $options['them'] = 'dark';
        $options['language'] = 'en_us';
        foreach ($params as $key) {
            if (isset($this->clientOptions[$key])) {
                $options[$key] = $this->clientOptions[$key];
            }
        }
        $this->clientOptions = $options;
    }

}
