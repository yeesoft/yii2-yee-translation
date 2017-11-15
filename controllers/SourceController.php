<?php

namespace yeesoft\translation\controllers;

use Yii;
use yeesoft\controllers\CrudController;

/**
 * SourceController implements the CRUD actions for yeesoft\translation\models\MessageSource model.
 */
class SourceController extends CrudController
{

    public $modelClass = 'yeesoft\translation\models\MessageSource';
    public $enableOnlyActions = ['update', 'create', 'delete'];

    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            case 'delete':
                return ['default/index'];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->modelClass;

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->category || $model->category == ' ') {
                $model->category = trim(Yii::$app->request->post('category'));
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your item has been created.');
                return $this->redirect($this->getRedirectPage('create', $model));
            }
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->category) {
                $model->category = Yii::$app->request->post('category');
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your item has been updated.');
                return $this->redirect($this->getRedirectPage('update', $model));
            }
        }
        return $this->renderIsAjax('update', compact('model'));
    }

}
