<?php

namespace app\models;


use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property Comment[] $comments
 * @property PostTag[] $postTags
 */
class Post extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'description', 'content'], 'required'],
            [['title','description','content'], 'string'],
            [['date'], 'date', 'format'=>'php:d-m-y'],
            [['date'], 'default', 'value' => date('d-m-y')],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostTags]].
     *
     * @return ActiveQuery
     */
    public function getPostTags(): ActiveQuery
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if($category)
        {
            $this->link('category', $category);
            return true;
        }

    }

    public function getTags()
    {
        try {
            return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
                ->viaTable('post_tag', ['post_id' => 'id']);
        } catch (InvalidConfigException $e) {
            //TODO: отлов ошибок
        }
    }

    public function getSelectedTags(): array
    {
        $selectedIDs = $this->getTags()->select('id')->asArray()->all();

        return ArrayHelper::getColumn($selectedIDs, 'id');
    }

    public function saveTags($tags): void
    {
        if (is_array($tags))
        {
             $this->clearAttachedTags();

             foreach($tags as $tag_id)
             {
                 $tag = Tag::findOne($tag_id);
                 $this->link('tags', $tag);
             }
        }
    }

    public function clearAttachedTags(): void
    {
        PostTag::deleteAll(['post_id' => $this->id]);
    }

    public function savePost()
    {
        $this->user_id = Yii::$app->user->id;
        return $this->save();
    }

    public function saveImage($filename)
    {
        $this->image = $filename;

        return $this->save(false);
    }

    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }
}
