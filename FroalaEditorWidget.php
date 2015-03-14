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
        /*
         * Language fix
         * @author <https://github.com/dungphanxuan>
         */
        if (!isset($this->options['lang']) || empty($this->options['lang'])) {
            $this->options['lang'] = strtolower(substr(Yii::$app->language, 0, 2));
        }
        $options = empty($this->options) ? '' : Json::encode($this->options);
        $asset = FroalaEditorAsset::register($view);
        $id = $this->options['id'];

        $this->updateAsset();
        $view ->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js');
        $view ->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css');
        $js = "
         $('#".$id ."').editable({inlineMode: false, alwaysBlank: true});
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

}
