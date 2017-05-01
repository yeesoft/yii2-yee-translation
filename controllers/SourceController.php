<?php

namespace yeesoft\translation\controllers;

use yeesoft\controllers\admin\BaseController;
use yeesoft\models\User;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * SourceController implements the CRUD actions for yeesoft\translation\models\MessageSource model.
 */
class SourceController extends BaseController
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
                return ['/translation/default/index'];
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
                Yii::$app->session->setFlash('crudMessage', 'Your item has been created.');
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

        if ($model->immutable && !User::hasPermission('updateImmutableSourceMessages')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->category) {
                $model->category = Yii::$app->request->post('category');
            }

            // print_r($model);die;

            if ($model->save()) {
                Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Your item has been updated.'));
                return $this->redirect($this->getRedirectPage('update', $model));
            }
        }
        return $this->renderIsAjax('update', compact('model'));
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->immutable && !User::hasPermission('updateImmutableSourceMessages')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $model->delete();

        Yii::$app->session->setFlash('crudMessage', 'Your item has been deleted.');
        return $this->redirect($this->getRedirectPage('delete', $model));
    }
}
