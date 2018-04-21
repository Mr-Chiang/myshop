<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180318_031727_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('分类名称'),
            'parent_id' => $this->integer()->comment('父级id'),
            'intro' => $this->string()->comment('分类简介'),
            'left' => $this->integer()->comment('左值'),
            'right' => $this->integer()->comment('右值'),
            'tree' => $this->integer()->comment('分组')->defaultValue(0),
            'is_display' => $this->string()->comment('软删除'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
