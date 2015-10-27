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

    /**
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())
            && $model->save()
            && $model->setTypes(Yii::$app->request->post($model->formName()))
        ) {
            //return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
