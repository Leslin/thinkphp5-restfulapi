ThinkPHP restfulapi
====================
[![LICENSE](https://img.shields.io/badge/license-NPL%20(The%20996%20Prohibited%20License)-blue.svg)](https://github.com/996icu/996.ICU/blob/master/LICENSE)
====================

基于ThinkPHP5.1* 基础上开发的一个简单的restful api ，带权限验证等

> ThinkPHP5.1的运行环境要求PHPPHP7.2+以上。

详细开发文档参考 [ThinkPHP5完全开发手册](https://www.kancloud.cn/manual/thinkphp5_1/353946)


## 使用目前tp5.1相关新增功能，包含容器依赖注入、Facade、验证器等，与上一个版本相比，简化代码量，整个代码量只有不到200行，增加鉴权白名单，refresh_token、全局异常处理等
## 欢迎PR
## 老版本tp5.0*相关代码请到release下载对应代码

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）==
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─api                接口目录
│  │  ├─controller      控制器目录
│  │  │     ├─v1        版本1目录
|  |  |     ├─v2        版本2目录
│  │  ├─Api.php         授权基类
│  │  ├─Oauth.php       授权验证
│  │  ├─Send.php        返回格式
|  |  |─exception       重写异常
│  │  ├─model           模型目录
|  |      ├─model     
│  │  ├─view            视图目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行工具配置文件
│  ├─common.php         公共函数文件
│  ├─config.php         公共配置文件
│  ├─route.php          路由配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─database.php       数据库配置文件
|─config                配置文件
|-routte                路由文件
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  ├─phpunit.xml        phpunit配置文件
│  └─start.php          框架入口文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

## 流程

-  router.php中定义了restful资源路由，具体请查看代码。

-  访问相应的url，例如：http://localhost/tp5test/public/index.php/v1/user

-  user控制器是继承了Api类

-  在Api类中，会有方法init()检测用户是否有权限调用接口

-  init方法会调用Oauth类中的鉴权，$oauth = app('app\api\controller\Oauth');;

-  根据用户端传递过来的app_key获取缓存中的access_token，在进行对比，如果true，则可以调用user中的各种方法，否则返回不能调用原因

-  Oauth类中的具体请看代码

-  生成access_token，缓存access_token等相关逻辑在v1/Token.php代码中，使用的是本地缓存，如果需要使用数据库或者redis请查询相关注释说明

-  api端请求需要在header中进行authentication字段拼接，拼接规则：authentication:USERID base64_encode(appid:accesstoken:uid)
PS:拼接示例：USERID c25haWx5X3hjeF9uZXc6M0U1TjBtR3dGSTZjZ1BoNEpLdHY4eWQyOVpqTXM3a2Y6Mzgw ，其中USERID后面跟了个空格，空格后面的一串字符串就是appid:accesstoken:uid这几个参数base64_encode后的字符串

-  uid 就是请求生成token时候返回

### 不知道header怎么传，请查看文档最后一张图，如果对参数不明白，请查看代码/Application/api/controller/Oauth.php中getClient方法，里面有逆向解密authentication值。

## 相关流程截图

### 流程图

![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/accesstoken.png)

### 截图

- 路由设置 route\route.php

![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/1route.png)

- Api类

![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/1api.png)

- Oauth类

![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/1oauth.png)

- v1/Token类

![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/1token.png)

### 截图
### 1、获取token传参

![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/1test1.png)

### 2、获取token、刷新的token，过期时间，用户信息
![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/1test2.png)


### 3、传递token进行请求
- 加密头规则：USERID base64_encode(appid:token:uid)
![](https://github.com/Leslin/thinkphp5-restfulapi/blob/master/screenshot/test4.png)


## 快速创建一个restful控制器

cd 到项目根目录

命令行 ：php think make:controller api/v1/Goods

修改路由，注册一个资源路由：在route.php加入下面一行代码：
Route::resource(':version/goods','api/:version.Goods'); 

## 其他说明
交流QQ群号：645233951
## 版权信息

遵循Apache2开源协议发布，并提供免费使用。
