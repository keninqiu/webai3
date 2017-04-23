<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mode_category".
 *
 * @property integer $id
 * @property integer $mode_id
 * @property integer $category_id
 */
class ModeCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mode_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mode_id', 'category_id'], 'required'],
            [['mode_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mode_id' => Yii::t('app', 'Mode ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }
}
