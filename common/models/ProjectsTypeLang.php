<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "projects_type_lang".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $language
 * @property string $name
 */
class ProjectsTypeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_type_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'language'], 'required'],
            [['type_id'], 'integer'],
            [['language', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'type_id' => Yii::t('backend', 'Type ID'),
            'language' => Yii::t('backend', 'Language'),
            'name' => Yii::t('backend', 'Name'),
        ];
    }
}
