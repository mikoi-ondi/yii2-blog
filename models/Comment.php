<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $user_id
 * @property int|null $post_id
 * @property int|null $status
 *
 * @property Post $post
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'status'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'user_id' => 'User ID',
            'post_id' => 'Post ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
