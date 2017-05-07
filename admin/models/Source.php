<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "source".
 *
 * @property integer $id
 * @property string $url
 * @property integer $status
 */
class Source extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
