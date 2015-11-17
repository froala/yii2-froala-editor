<?php

namespace froala\editor;

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
            $view->registerCssFile($asset->baseUrl . "/css/themes/{$themeType}.css", ['depends' => '\froala\editor\FroalaEditorAsset']);
        }
        //language
        $langType = isset($this->clientOptions['language']) ? $this->clientOptions['language'] : 'en_us';
        if ($langType != 'es_us') {
            $view->registerJsFile($asset->baseUrl . "/js/languages/{$langType}.js", ['depends' => '\froala\editor\FroalaEditorAsset']);
        }

        $options = empty($this->options) ? '' : Json::encode($this->options);
        $id = $this->options['id'];

        $this->updateAsset();
        $view ->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js');
        $view ->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css');
        $varName = self::PLUGIN_NAME . '_' . str_replace('-', '_', $id);
        $js = "
         $('#".$id ."').froalaEditor(
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
          'charCounterCount',
          'charCounterMax',
          'codeBeautifier',
          'codeMirror',
          'codeMirrorOptions',
          'colorsBackground',
          'colorsDefaultTab',
          'colorsStep',
          'colorsText',
          'direction',
          'disableRightClick',
          'editInPopup',
          'editorClass',
          'emoticonsSet',
          'emoticonsStep',
          'enter',
          'entities',
          'fileAllowedTypes',
          'fileMaxSize',
          'fileUploadMethod',
          'fileUploadParam',
          'fileUploadParams',
          'fileUploadToS3',
          'fileUploadURL',
          'fileUseSelectedText',
          'fontFamily',
          'fontFamilySelection',
          'fontSize',
          'fontSizeSelection',
          'fullPage',
          'height',
          'heightMax',
          'heightMin',
          'htmlAllowComments',
          'htmlAllowedAttrs',
          'htmlAllowedEmptyTags',
          'htmlAllowedTags',
          'htmlRemoveTags',
          'htmlSimpleAmpersand',
          'iframe',
          'iframeStyle',
          'imageAllowedTypes',
          'imageAltButtons',
          'imageDefaultAlign',
          'imageDefaultDisplay',
          'imageDefaultWidth',
          'imageEditButtons',
          'imageInsertButtons',
          'imageManagerDeleteMethod',
          'imageManagerDeleteParams',
          'imageManagerDeleteURL',
          'imageManagerLoadMethod',
          'imageManagerLoadParams',
          'imageManagerLoadURL',
          'imageManagerPageSize',
          'imageManagerPreloader',
          'imageManagerScrollOffset',
          'imageMaxSize',
          'imageMove',
          'imageMultipleStyles',
          'imagePaste',
          'imageResize',
          'imageResizeWithPercent',
          'imageSizeButtons',
          'imageStyles',
          'imageTextNear',
          'imageUploadMethod',
          'imageUploadParam',
          'imageUploadParams',
          'imageUploadToS3',
          'imageUploadURL',
          'initOnClick',
          'inlineStyles',
          'keepFormatOnDelete',
          'language',
          'lineBreakerOffset',
          'lineBreakerTags',
          'linkAlwaysBlank',
          'linkAlwaysNoFollow',
          'linkAttributes',
          'linkAutoPrefix',
          'linkConvertEmailAddress',
          'linkEditButtons',
          'linkInsertButtons',
          'linkList',
          'linkMultipleStyles',
          'linkStyles',
          'linkText',
          'multiLine',
          'paragraphFormat',
          'paragraphFormatSelection',
          'paragraphMultipleStyles',
          'paragraphStyles',
          'pasteAllowLocalImages',
          'pasteDeniedAttrs',
          'pasteDeniedTags',
          'pastePlain',
          'placeholderText',
          'requestHeaders',
          'requestWithCORS',
          'saveInterval',
          'saveMethod',
          'saveParam',
          'saveParams',
          'saveURL',
          'scrollableContainer',
          'shortcutsEnabled',
          'spellcheck',
          'tabSpaces',
          'tableCellMultipleStyles',
          'tableCellStyles',
          'tableColors',
          'tableColorsButtons',
          'tableColorsStep',
          'tableEditButtons',
          'tableInsertButtons',
          'tableInsertMaxSize',
          'tableMultipleStyles',
          'tableResizerOffset',
          'tableResizingLimit',
          'tableStyles',
          'theme',
          'toolbarBottom',
          'toolbarButtons',
          'toolbarButtonsMD',
          'toolbarButtonsSM',
          'toolbarButtonsXS',
          'toolbarInline',
          'toolbarSticky',
          'toolbarStickyOffset',
          'toolbarVisibleWithoutSelection',
          'typingTimer',
          'useClasses',
          'videoDefaultAlign',
          'videoDefaultDisplay',
          'videoEditButtons',
          'videoInsertButtons',
          'videoResize',
          'videoSizeButtons',
          'videoTextNear',
          'width',
          'zIndex'
        ];
        $options = [];
        $options['height'] = '80px';
        $options['theme'] = 'dark';
        $options['language'] = 'en_us';
        foreach ($params as $key) {
            if (isset($this->clientOptions[$key])) {
                $options[$key] = $this->clientOptions[$key];
            }
        }
        $this->clientOptions = $options;
    }

}
