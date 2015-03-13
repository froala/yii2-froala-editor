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
            echo "ok";
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


        $js = "
              $('#edit').editable({inlineMode: false})
        ";
        $view->registerJs($js);
    }

    /**
     * client options init
     */
    protected function initClientOptions()
    {
        // KindEditor optional parameters
        $params = [
            'width',
            'height',
            'minWidth',
            'minHeight',
            'items',
            'noDisableItems',
            'filterMode',
            'htmlTags',
            'wellFormatMode',
            'resizeType',
            'themeType',
            'langType',
            'designMode',
            'fullscreenMode',
            'basePath',
            'themesPath',
            'pluginsPath',
            'langPath',
            'minChangeSize',
            'urlType',
            'newlineTag',
            'pasteType',
            'dialogAlignType',
            'shadowMode',
            'zIndex',
            'useContextmenu',
            'syncType',
            'indentChar',
            'cssPath',
            'cssData',
            'bodyClass',
            'colorTable',
            'afterCreate',
            'afterChange',
            'afterTab',
            'afterFocus',
            'afterBlur',
            'afterUpload',
            'uploadJson',
            'fileManagerJson',
            'allowPreviewEmoticons',
            'allowImageUpload',
            'allowFlashUpload',
            'allowMediaUpload',
            'allowFileUpload',
            'allowFileManager',
            'fontSizeTable',
            'imageTabIndex',
            'formatUploadUrl',
            'fullscreenShortcut',
            'extraFileUploadParams',
            'filePostName',
            'fillDescAfterUploadImage',
            'afterSelectFile',
            'pagebreakHtml',
            'allowImageRemote',
            'autoHeightMode',
        ];
        $options = [];
        $options['width'] = '680px';
        $options['height'] = '350px';
        $options['themeType'] = 'default';
        $options['langType'] = 'zh_CN';
        $options['afterChange'] = new JsExpression('function(){this.sync();}');
        foreach ($params as $key) {
            if (isset($this->clientOptions[$key])) {
                $options[$key] = $this->clientOptions[$key];
            }
        }
        // $_POST['_csrf'] = ...
        $options['extraFileUploadParams'][Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
        // $_POST['PHPSESSID'] = ...
        $options['extraFileUploadParams'][Yii::$app->session->name] = Yii::$app->session->id;
        if (Yii::$app->request->enableCsrfCookie) {
            // $_POST['_csrfCookie'] = ...
            $options['extraFileUploadParams'][$this->csrfCookieParam] = $_COOKIE[Yii::$app->request->csrfParam];
        }
        $this->clientOptions = $options;
    }
}
