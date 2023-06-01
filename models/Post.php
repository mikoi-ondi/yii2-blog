<?php

namespace app\models;

use Yii;

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
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'content'], 'string'],
            [['date'], 'safe'],
            [['viewed', 'user_id', 'status', 'category_id'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }
}
