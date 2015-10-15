<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "projects_files".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $type
 * @property string $image_base_url
 * @property string $image_path
 * @property string $image_type
 */
class ProjectsFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id'], 'required'],
            [['project_id'], 'integer'],
            [['type', 'image_type'], 'string', 'max' => 255],
            [['image_base_url', 'image_path'], 'string', 'max' => 1024]
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
            'type' => Yii::t('backend', 'Type'),
            'image_base_url' => Yii::t('backend', 'Image Base Url'),
            'image_path' => Yii::t('backend', 'Image Path'),
            'image_type' => Yii::t('backend', 'Image Type'),
        ];
    }
}
