<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_content".
 *
 * @property int $id
 * @property string $detail 文章内容
 * @property int $article_id 文章id
 * @property int $is_display 软删除
 */
class ArticleContent extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail'], 'string'],
            [['detail'],'required'],
            [['article_id', 'is_display'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detail' => '文章内容',
            'article_id' => '文章id',
            'is_display' => '软删除',
        ];
    }
}
