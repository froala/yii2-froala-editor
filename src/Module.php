<?php

namespace Froala\Editor;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'Froala\Editor\controllers';

	// Without false it will give "Bad Request (#400) Unable to verify your data submission."
	public $enableCsrfValidation = false;

	public $uploadFolder;
}
