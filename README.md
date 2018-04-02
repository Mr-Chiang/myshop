# 1.项目介绍
## 1.1.项目描述简介
类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存 CRM客户关系管理)
电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。
为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。
为了让大家掌握公司协同开发要点，我们使用git管理代码。
在项目中会使用很多前面的知识，比如架构、维护等等。
## 1.2.主要功能模块
系统包括：
后台：品牌管理、文章管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
前台：首页、商品展示、商品购买、订单管理、在线支付等。
## 1.3.开发环境和技术

开发环境 | Window
---|---
开发工具 | Phpstorm+PHP7.0+GIT+Apache
相关技术 | Yii2.0+CDN+jQuery+sphinx
## 1.4.项目人员组成周期成本
### 1.4.1.人员组成

职位 | 人数 | 备注
---|---|---
项目经理和组长 | 1 | 一般小公司由项目经理负责管理，中大型公司项目由项目经理或组长负责管理
后台开发人员 | 2-3	|
UI设计人员 |	0	|
前端开发人员 |	1 |	专业前端不是必须的，所以前端开发和UI设计人员可以同一个人
测试人员 |	1	| 有些公司并未有专门的测试人员，测试人员可能由开发人员完成测试。公司有测试部，测试部负责所有项目的测试。项目测试由产品经理进行业务测试。项目中如果有测试，一般都具有Bug管理工具。（介绍某一个款，每个公司Bug管理工具不一样）
### 1.4.2.项目周期成本




人数 |	周期 |	备注
---|---|---
1 |	两周需求及设计 |	项目经理 
1 |	两周 | UI设计	UI/UE
4 （1测试  2后端  1前端）|	3个月 第1周需求设计 4-8周时间完成编码 1-2周时间进行测试和修复	|开发人员、测试人员
# 2.系统功能模块
## 2.1.需求
品牌管理：已完成

文章管理：已完成

商品分类管理：已完成

商品管理：已完成

账号管理：

权限管理：

菜单管理：

订单管理：

## 2.2.流程
自动登录流程
购物车流程
订单流程
## 2.3.设计要点（数据库和页面交互）
系统前后台设计：前台www.yiishop.com 后台admin.yiishop.com 对url地址美化
商品无限级分类设计：
购物车设计

## 2.4.要点难点及解决方案
难点在于需要掌握实际工作中，如何分析思考业务功能，如何在已有知识积累的前提下搜索并解决实际问题，抓大放小，融会贯通，尤其要排除畏难情绪。
# 3.品牌功能模块
## 3.1.需求
品牌管理功能涉及品牌的列表展示、品牌添加、修改、删除功能。
品牌需要保存缩略图和简介。
品牌删除使用逻辑删除。 
## 3.2.流程

## 3.3.设计要点（数据库和页面交互）

## 3.4.要点难点及解决方案
1.删除使用逻辑删除,只改变status属性,不删除记录
2.使用webuploader插件,提升用户体验
3.使用composer下载和安装webuploader
4.composer安装插件报错,解决办法:
composer global require "fxp/composer-asset-plugin:^1.2.0"
5.注册七牛云账号
# 4.文章管理模块
## 4.1.需求
文章的增删改查
文章分类的增删改查
## 4.2.设计要点
文章模型和文章详情模型建立1对1关系
## 4.3.要点难点及解决方案
1.文章分类不能重复,通过添加验证规则unique解决
2.文章垂直分表,创建表单使用文章模型和文章详情模型
# 5.商品分类模块
## 5.1.需求
1.商品分类的增删改查
2.商品分类支持无限级分类
3.方便直观的显示分类层级
4.分类层级允许修改
5.2.设计要点


1.使用嵌套集合模型
2.使用ztree插件显示分类层级(官方网站http://www.treejs.cn)
3.商品分类数据表设计

## 5.3.流程
1.安装nested set插件: composer require creocoder/yii2-nested-sets
2.配置NestedSetsBehavior
3.下载ztree插件:http://www.treejs.cn
## 5.4.难点
1.嵌套集合相关理论知识,可以参考http://blog.csdn.net/gongpeng1966/article/details/52910924;https://my.oschina.net/amoswork/blog/280142
2.nestedset行为的配置和使用
3.ztree插件的使用
4.健壮性是最大难点，利用左值比自身大且右值比自身小找出子类
#6.商品管理模块
##6.1.需求
1.保存每天创建多少商品,创建商品的时候,更新当天创建商品数量
2.商品增删改查
3.商品列表页可以进行搜索(商品名,商品状态,售价范围 
4.新增商品自动生成sn,规则为年月日+今天的第几个商品,比如201704010001 
5.商品详情使用ueditor插件 

#.会员管理
##7.1.需求
1.管理员增删改查
2.管理员登录和注销
3.自动登录(基于cookie)
4.促销管理(选做)
7.2.要点
1.创建admin表(在user表基础上添加最后登录时间和最后登录ip)

##6.2.要点难点及解决方案
1.商品分类只能选择第三级分类
2.品牌使用下拉选择
3.商品相册,添加完商品后,跳转到添加商品相册页面,允许多图片上传
4.创建goods_day_count数据迁移时,如何创建date类型主键
##6.3总结
1.在自动生成编号sn时，最开始考虑不全，导致后面出现bug,可利用时间加几位数组合，在库中找出最大值再加1生成唯一编号；
2.在用了compact传值视图后，在传变量过去需提出来，因此命令只能传数组；
3.在做搜索功能时会用到较为复杂的查询语句，特别是多个模糊查询，需用andFilewhere和orFilewhere结合一起用。
4.yii中的cookie自动登录看不懂文档。"# newShop" 
"# myshop" 
