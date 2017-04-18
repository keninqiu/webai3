<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $type
 * @property string $path
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        
            [['product_id', 'path'], 'required'],
            [['product_id', 'type'], 'integer'],
            
            [['path'], 'string'],
            
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'type' => 'Type',
            'path' => 'Path',
        ];
    }

    public function upload()
    {
        $image = '/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        $this->path = '/admin'.$image;
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@app') . $image);
            return true;
        } else {
            return false;
        }
    }    
}
