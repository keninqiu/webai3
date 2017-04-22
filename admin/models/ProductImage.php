<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $type_id
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
            [['product_id', 'type_id'], 'integer'],
            
            [['path'], 'string'],
            
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,jpeg'],
        
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product',
            'type_id' => 'Type',
            'path' => 'Path',
        ];
    }

    public function upload()
    {
        $imageDir = '/uploads/' . $this->product_id;
        $imageAbsDir = Yii::getAlias('@app') . $imageDir;
        if(!file_exists($imageAbsDir)) {
            mkdir($imageAbsDir);
        }
        $image = $imageDir . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        $this->path = '/admin'.$image;
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@app') . $image);
            return true;
        } else {
            return false;
        }
    } 

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }    

    public function getType() {
        return $this->hasOne(ImageType::className(), ['id' => 'type_id']);
    }          
}
