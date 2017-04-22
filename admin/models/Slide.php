<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slide".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $text
 * @property integer $position_id
 */
class Slide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slide';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path', 'text'], 'required'],
            [['position_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['path'], 'string', 'max' => 100],
            [['text'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'path' => Yii::t('app', 'Path'),
            'text' => Yii::t('app', 'Text'),
            'position_id' => Yii::t('app', 'Position'),
        ];
    }

    public function getPosition() {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }    
}
