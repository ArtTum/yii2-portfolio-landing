<?php

namespace backend\controllers;

use Yii;
use common\models\WidgetMenu;

/**
 * WidgetMenuController implements the CRUD actions for WidgetMenu model.
 */
class WidgetMenuController extends TypicalBackendController
{

    function init(){
        $this->currentModel = new WidgetMenu();
    }

    /**
     * Create new menu and menu items.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WidgetMenu();

        if ($model->load(Yii::$app->request->post())
            && $model->save()
            && $model->setItems(Yii::$app->request->post($model->formName()))
        ) {
            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Update an existing menu and menu items.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())
            && $model->save()
            && $model->setItems(Yii::$app->request->post($model->formName()))
        ) {
            //return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
