<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_tag}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%post}}`
 * - `{{%tag}}`
 */
class m230601_143036_create_post_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_tag}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-post_tag-post_id}}',
            '{{%post_tag}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-post_tag-post_id}}',
            '{{%post_tag}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            '{{%idx-post_tag-tag_id}}',
            '{{%post_tag}}',
            'tag_id'
        );

        // add foreign key for table `{{%tag}}`
        $this->addForeignKey(
            '{{%fk-post_tag-tag_id}}',
            '{{%post_tag}}',
            'tag_id',
            '{{%tag}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-post_tag-post_id}}',
            '{{%post_tag}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-post_tag-post_id}}',
            '{{%post_tag}}'
        );

        // drops foreign key for table `{{%tag}}`
        $this->dropForeignKey(
            '{{%fk-post_tag-tag_id}}',
            '{{%post_tag}}'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            '{{%idx-post_tag-tag_id}}',
            '{{%post_tag}}'
        );

        $this->dropTable('{{%post_tag}}');
    }
}
