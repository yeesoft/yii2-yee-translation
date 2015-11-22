<?php

namespace yeesoft\translation\controllers;

use yeesoft\controllers\admin\BaseController;
use Yii;
use yeesoft\translation\models\Message;
use yii\base\Model;
use yeesoft\translation\models\MessageSource;
use yeesoft\helpers\LanguageHelper;
use yeesoft\models\User;

/**
 * MessageController implements the CRUD actions for yeesoft\translation\models\Message model.
 */
class DefaultController extends BaseController
{
    public $modelClass        = 'yeesoft\translation\models\Message';
    public $enableOnlyActions = ['index'];

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sourceLanguage = 'en';

        $languages  = LanguageHelper::getLanguages();
        $categories = MessageSource::getMessageCategories();

        unset($languages[$sourceLanguage]);

        $currentLanguage = Yii::$app->getRequest()->get('translation', NULL);
        $currentCategory = Yii::$app->getRequest()->get('category', NULL);

        if (!in_array($currentLanguage, array_keys($languages))) {
            $currentLanguage = NULL;
        }

        if (!in_array($currentCategory, array_keys($categories))) {
            $currentCategory = NULL;
        }

        if ($currentLanguage && $currentCategory) {

            Message::initMessages($currentCategory, $currentLanguage);

            $messageIds   = MessageSource::getMessageIdsByCategory($currentCategory);
            $sourceTable  = MessageSource::tableName();
            $messageTable = Message::tableName();

            $messages = Message::find()
                ->andWhere(['IN', 'source_id', $messageIds])
                ->andWhere(['language' => $currentLanguage])
                ->indexBy('id')
                ->all();
        } else {
            $messages = [];
        }

        if (User::hasPermission('updateTranslations') && Message::loadMultiple($messages, Yii::$app->request->post())
            && Model::validateMultiple($messages)) {
            foreach ($messages as $message) {
                $message->save(false);
            }

            Yii::$app->session->setFlash('crudMessage', 'Your item has been updated.');
            return $this->refresh();
        }

        return $this->render('index', [
                'messages' => $messages,
                'languages' => $languages,
                'categories' => $categories,
                'currentLanguage' => $currentLanguage,
                'currentCategory' => $currentCategory,
        ]);
    }
}