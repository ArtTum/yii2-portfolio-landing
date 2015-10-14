<?php

namespace backend\controllers;

use common\models\Employers;
use Yii;

/**
 * SkillsController implements the CRUD actions for I18nMessage model.
 */
class EmployersController extends TypicalBackendController
{
    function init(){
        $this->currentModel = new Employers();
        parent::init();
    }
}
