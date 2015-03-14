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
         * @author <https://github.com/sim2github>
         */
        if (!isset($this->options['lang']) || empty($this->options['lang'])) {
            $this->options['lang'] = strtolower(substr(Yii::$app->language, 0, 2));
        }
        $options = empty($this->options) ? '' : Json::encode($this->options);
        $asset = FroalaEditorAsset::register($view);

        $js = "
        ";
        $view->registerJs($js);
    }

}
