<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;



    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg, png ']
        ];
    }


    /**
     * @param $file
     * @return string
     */
    public function uploadImage(UploadedFile $file, $currentImage)
    {
        $this->image = $file;

        if($this->validate())
        {
            $this->deleteCurrentImage($currentImage);
            $filename = $this->prepareFileName();
            $file->saveAs(file: Yii::getAlias('@web') . 'uploads/' . $filename);
            return $filename;
        }


    }

    private function prepareFileName()
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        if(file_exists(Yii::getAlias('@web') . 'uploads/' . $currentImage))
        {
            @unlink(Yii::getAlias('@web') . 'uploads/' . $currentImage);
        }
    }

}