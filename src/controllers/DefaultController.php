<?php

namespace froala\froalaeditor\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
	// Without false it will give "Bad Request (#400) Unable to verify your data submission."
    public $enableCsrfValidation = false;

    public function actionUpload()
    {
		// Store the image.
	    try {
			$uploadFolder = $this->module->uploadFolder;

		    $response = \FroalaEditor_Image::upload($uploadFolder);
		    echo stripslashes(json_encode($response));
	    }
	    catch (Exception $e) {
		    http_response_code(404);
	    }

    }
}
