<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "projects_lang".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string $case_url
 */
class ProjectsLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'language'], 'required'],
            [['project_id'], 'integer'],
            [['title', 'description'], 'string'],
            [['language'], 'string', 'max' => 5],
            [['case_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'project_id' => Yii::t('backend', 'Project ID'),
            'language' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'case_url' => Yii::t('backend', 'Case Url'),
        ];
    }
}
