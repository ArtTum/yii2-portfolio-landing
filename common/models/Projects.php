<?php

namespace common\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;
use dosamigos\translateable\TranslateableBehavior;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $active
 * @property integer $sort
 * @property string $site_url
 * @property string $tools
 * @TODO: Multiple file upload
 * @TODO: Dropdown with add option
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'active', 'sort'], 'integer'],
            [['active', 'title', 'tools', 'sort'], 'required'],
            [['tools', 'title', 'description'], 'string'],
            [['site_url', 'case_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            /*[
                'class' => UploadBehavior::className(),
                'attribute' => 'flag',
                'pathAttribute' => 'flag_path',
                'baseUrlAttribute' => 'flag_base_url',
                'typeAttribute' => 'flag_type'
            ],*/
            'trans' => [
                'class' => TranslateableBehavior::className(),
                'translationAttributes' => [
                    'title',
                    'description',
                    'case_url'
                ]
            ]
        ];
    }

    /**
     * Init function
     * @defaultParam sort = 500
     */
    public function init()
    {
        if (empty($this->sort))
            $this->sort = 500;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'type_id' => Yii::t('backend', 'Type ID'),
            'title' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
            'active' => Yii::t('backend', 'Active'),
            'sort' => Yii::t('backend', 'Sort'),
            'site_url' => Yii::t('backend', 'Site Url'),
            'case_url' => Yii::t('backend', 'Case Url'),
            'tools' => Yii::t('backend', 'Tools'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ProjectsLang::className(), ['project_id' => 'id']);
    }

    /**
     * Delete translated params.
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            ProjectsLang::deleteAll(['project_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return ProjectsType::find()->orderBy("sort")->all();
    }

    /**
     * Save or update project types
     * @param array $types
     * @return bool
     */
    public function setTypes($types = array())
    {
        if (empty($types)) {
            return true;
        }

        $_dbItemsIds = $_formItemsIds = array();
        //Get all current menu items from database
        $_dbItemsData = ProjectsType::find()->all();
        foreach ($_dbItemsData as $_dbItem) {
            $_dbItemsIds[] = $_dbItem->id;
            $_dbItems[$_dbItem->id] = $_dbItem;
        }
        foreach ($types['types'] as $type) {
            //Create new item
            if (empty($type['id'])) {
                $_newItem = new ProjectsType();
                $_newItem->setAttributes($type, false);
                $_newItem->save();
                $type['id'] = $_newItem->id;
                $_dbItems[$type['id']] = $_newItem;
            }
            $_dbItems[$type['id']]->updateAttributes($type);
            $_dbItems[$type['id']]->save();
            $_formItemsIds[] = $type['id'];
        }
        //Check elements for deleting
        $_deleteItems = array_diff($_dbItemsIds, $_formItemsIds);
        if (sizeof($_deleteItems) > 0) {
            ProjectsType::deleteAll(['id' => $_deleteItems]);
            ProjectsTypeLang::deleteAll(['type_id' => $_deleteItems]);
        }
    }
}
