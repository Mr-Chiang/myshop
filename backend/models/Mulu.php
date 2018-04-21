<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mulu".
 *
 * @property int $id
 * @property string $name 目录名称
 * @property string $ico 目录图标
 * @property string $url 目录地址
 * @property int $parent_id 父级id
 */
class Mulu extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name', 'ico', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '目录名称',
            'ico' => '目录图标',
            'url' => '目录地址',
            'parent_id' => '父级id',
        ];
    }

    public static function menu(){
         $menu = [];
         //找到一级目录
        $parents = self::find()->where(['parent_id'=>0])->all();
        foreach ($parents as  $kk){
            $menu['label'] = $kk->name;
            $menu['icon'] = $kk->icon;
            $menu['url'] = $kk->url;
            $children = self::find()->where(['parent_id'=>$kk->id])->all();

            foreach ($children as $vv){
                $arr1 = [];
//                var_dump($vv->name);exit;
                $arr1['label'] = $vv->name;
                $arr1['icon'] = $vv->icon;
                $arr1['url'] = $vv->url;
                $child = self::find()->where(['parent_id'=>$vv->id])->all();
                foreach ($child as $jj){
                    $arr2 = [];
                    $arr2['label'] = $jj->name;
                    $arr2['icon'] = $jj->icon;
                    $arr2['url'] = $jj->url;
                    $arr1['items'][] = $arr2;
                }
                $menu['items'][] = $arr1;
            }

        }
        return $menu;
    }
}
