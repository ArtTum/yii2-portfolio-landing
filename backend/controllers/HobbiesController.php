<?php

namespace backend\controllers;

use common\models\Hobbies;
use Yii;
/**
 * HobbiesController implements the CRUD actions for I18nMessage model.
 */
class HobbiesController extends TypicalBackendController
{
    function init(){
        $this->currentModel = new Hobbies();
        parent::init();
    }
}
