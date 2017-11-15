<?php

namespace yeesoft\translation\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $language
 * @property string $translation
 *
 * @property MessageSource $id0
 */
class Message extends \yeesoft\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'language'], 'required'],
            [['source_id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(MessageSource::className(), ['id' => 'source_id']);
    }

    /**
     * @inheritdoc
     */
    public static function initMessages($category, $language)
    {
        $sources = MessageSource::getMessagesByCategory($category);

        $translations = Message::find()
                ->andWhere(['in', 'source_id', array_keys($sources)])
                ->andWhere(['language' => $language])
                ->select('source_id')
                ->column();

        $messagesToCreate = array_diff(array_keys($sources), $translations);

        foreach ($messagesToCreate as $sourceId) {
            $message = new Message();
            $message->source_id = $sourceId;
            $message->language = $language;
            $message->translation = '';
            $message->save();
        }

        return true;
    }

}
