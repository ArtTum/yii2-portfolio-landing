<?php

namespace backend\controllers;

use common\models\Skills;
use Yii;
/**
 * SkillsController implements the CRUD actions for I18nMessage model.
 */
class SkillsController extends TypicalBackendController
{
    function init(){
        $this->currentModel = new Skills();
    }
}
