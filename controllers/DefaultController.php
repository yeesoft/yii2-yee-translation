<?php

namespace yeesoft\translation\controllers;

use Yii;
use yii\base\Model;
use yii\db\Expression;
use yeesoft\controllers\CrudController;
use yeesoft\translation\models\Message;
use yeesoft\translation\models\MessageSource;

/**
 * MessageController implements the CRUD actions for yeesoft\translation\models\Message model.
 */
class DefaultController extends CrudController
{

    public $modelClass = 'yeesoft\translation\models\Message';
    public $enableOnlyActions = ['index'];

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sourceLanguage = Yii::$app->sourceLanguage;

        $languages = Yii::$app->languages;
        $categories = MessageSource::getMessageCategories();

        $currentLanguage = Yii::$app->getRequest()->get('translation', $sourceLanguage);
        $currentCategory = Yii::$app->getRequest()->get('category', empty($categories) ? null : array_keys($categories)[0]);

        if (!in_array($currentLanguage, array_keys($languages))) {
            $currentLanguage = null;
        }

        if (!in_array($currentCategory, array_keys($categories))) {
            $currentCategory = null;
        }

        if ($currentLanguage && $currentCategory) {
            if ($currentLanguage === $sourceLanguage) {

                $messages = MessageSource::getMessagesByCategory($currentCategory);
            } else {

                Message::initMessages($currentCategory, $currentLanguage);

                $sourceMessages = MessageSource::getMessagesByCategory($currentCategory);
                $orderBy = new Expression('FIELD (id, ' . implode(', ', array_keys($sourceMessages)) . ')');

                $messages = Message::find()
                                ->andWhere(['in', 'source_id', array_keys($sourceMessages)])
                                ->andWhere(['language' => $currentLanguage])
                                ->orderBy($orderBy)->indexBy('id')->all();
            }
        } else {
            $messages = [];
        }

        if (Yii::$app->user->can('update-translations') && Message::loadMultiple($messages, Yii::$app->request->post()) && Model::validateMultiple($messages)) {
            foreach ($messages as $message) {
                $message->save(false);
            }

            Yii::$app->session->setFlash('success', 'Your item has been updated.');
            return $this->refresh();
        }

        return $this->render('index', compact('messages', 'languages', 'categories', 'sourceLanguage', 'currentLanguage', 'currentCategory'));
    }

}
