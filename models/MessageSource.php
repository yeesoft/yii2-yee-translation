<?php

namespace yeesoft\translation\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "message_source".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class MessageSource extends \yeesoft\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message_source}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['message', 'category'], 'required'],
            [['category'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee', 'ID'),
            'category' => Yii::t('yee/translation', 'Category'),
            'message' => Yii::t('yee/translation', 'Source Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getMessageCategories()
    {
        $categories = (new Query())
            ->select(['category', 'count(*) AS count'])
            ->from(self::tableName())
            ->groupBy('category')
            ->orderBy(['category' => SORT_ASC])
            ->all();

        return ArrayHelper::map($categories, 'category', 'count');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getCategories()
    {
        $sources = MessageSource::find()->select(['category'])->distinct()->all();
        
        return ArrayHelper::map($sources, 'category', 'category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getMessagesByCategory($category)
    {
        return MessageSource::find()
                ->where(['category' => $category])
                ->orderBy(['message' => SORT_ASC])
                ->indexBy('id')->all();
    }

}