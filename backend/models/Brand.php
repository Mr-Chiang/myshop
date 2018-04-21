<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/15
 * Time: 19:58
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Brand extends ActiveRecord
{
    public $imgFile;
    public $code;
    public $file;


    public function rules()
    {
        return [
            [["name","intro","sort","file","logo","status","is_display"],"required"],
            [["sort"],"integer"],
            [["code"],"captcha","captchaAction" => "brand/code"],
            [["imgFile"],"image","extensions" => ["jpg","gif","png"],"skipOnEmpty" => false]

        ];
    }
    public function attributeLabels()
    {
        return [
            "name"=>"品牌名称",
            "intro"=>"品牌简介",
            "sort"=>"排行",
            "logo"=>"品牌图像",
            "status"=>"状态",
            "code"=>"请输入验证码"
        ];
    }

}