<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "languages_lang".
 *
 * @property integer $id
 * @property string $name
 * @property integer $language_id
 * @property string $language
 */
class LanguagesLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'language_id', 'language'], 'required'],
            [['language_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['language'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common_langugages_lang', 'ID'),
            'name' => Yii::t('common_langugages_lang', 'Name'),
            'language_id' => Yii::t('common_langugages_lang', 'Language ID'),
            'language' => Yii::t('common_langugages_lang', 'Language'),
        ];
    }
}
