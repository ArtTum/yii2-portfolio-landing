<?php

namespace common\models;

use Yii;
use dosamigos\translateable\TranslateableBehavior;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "employers".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $sort
 * @property string $image_base_url
 * @property string $image_path
 * @property string $image_type
 */
class Employers extends \yii\db\ActiveRecord
{
    /**
     * @var logo of company
     */
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employers';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'trans' => [
                'class' => TranslateableBehavior::className(),
                'translationAttributes' => [
                    'title',
                    'description',
                    'position',
                    'period'
                ]
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'image',
                'pathAttribute' => 'image_path',
                'baseUrlAttribute' => 'image_base_url',
                'typeAttribute' => 'image_type'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'title'], 'required'],
            [['active', 'sort'], 'integer'],
            [['description'], 'string', 'max' => 1500],
            [['image_base_url', 'image_path'], 'string', 'max' => 1024],
            [['image_type', 'position', 'period'], 'string', 'max' => 255],
            ['image', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'title' => Yii::t('backend', 'Name'),
            'image' => Yii::t('backend', 'Logo'),
            'description' => Yii::t('backend', 'Description'),
            'position' => Yii::t('backend', 'Position'),
            'period' => Yii::t('backend', 'Period'),
            'active' => Yii::t('backend', 'Active'),
            'sort' => Yii::t('backend', 'Sort'),
            'image_base_url' => Yii::t('backend', 'Image Base Url'),
            'image_path' => Yii::t('backend', 'Image Path'),
            'image_type' => Yii::t('backend', 'Image Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(EmployersLang::className(), ['employer_id' => 'id']);
    }
}
