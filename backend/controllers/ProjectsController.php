<?php

namespace backend\controllers;

use common\models\Projects;
use Yii;
/**
 * SkillsController implements the CRUD actions for I18nMessage model.
 */
class ProjectsController extends TypicalBackendController
{
    function init(){
        $this->currentModel = new Projects();
        parent::init();
    }
}
