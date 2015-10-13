<?php

namespace backend\controllers;

use common\models\Languages;
use Yii;

/**
 * LanguageController implements the CRUD actions for I18nMessage model.
 */
class LanguagesController extends TypicalBackendController
{
    function init(){
        $this->currentModel = new Languages();
    }
}
