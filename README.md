PaiAdmin 派后台管理系统
===============

> 运行环境要求PHP7.1+。  
> 开启Redis扩展

## 主要特性

### 开源无加密
源码开源无加密
### TP6框架
使用最新的 ThinkPHP 6.0框架开发
### 标准接口
标准接口、前后端分离，二次开发更方便
### 长连接
减少CPU及内存使用及网络堵塞，减少请求响应时长
### 无缝事件机制
行为扩展更方便，方便二次开发
### 后台快速生成表单
后台应用form-builder 无需写页面快速增删改查
### 强大的后台权限管理
后台多种角色、多重身份权限管理，权限可以控制到每一步操作
### 微信开发
后台已嵌入微信开发插件

## 特别感谢

[笔下光年 / Light Year Admin   一个基于Bootstrap v3.3.7的后台HTML模板。](https://gitee.com/yinqi/Light-Year-Admin-Template) 

[xaboy / form-builder PHP表单生成器，使用PHP快速生成现代化的form表单。](https://gitee.com/xaboy/form-builder) 

## 自动安装
1. 上传文件到网站根目录
2. 运行composer install 安装依赖
3. 修改目录权限（linux系统）777  
   /public
   /runtime
4. 配置好域名，在浏览器里打开域名，根据安装向导进行安装
5. 后台登录 http://域名/admin

注意：linux自动安装.env文件可能会被创建成文件夹，要手动修改下

## 手动安装

1.创建数据库，倒入数据库文件

数据库文件目录/public/install/learn.sql

2.修改数据库连接文件
配置文件路径/.env

~~~
APP_DEBUG = true

[APP]
DEFAULT_TIMEZONE = Asia/Shanghai

[DATABASE]
TYPE = mysql
HOSTNAME = 127.0.0.1 #数据库连接地址
DATABASE = test #数据库名称
USERNAME = username #数据库登录账号
PASSWORD = password #数据库登录密码
HOSTPORT = 3306 #数据库端口
CHARSET = utf8
DEBUG = true

[LANG]
default_lang = zh-cn
~~~
3.修改目录权限（linux系统）777
/public
/runtime

4.后台登录：
http://域名/admin

默认账号：admin 密码：123456

## 定时任务与长连接服务
启动
```sh
php think worker:server
```
linux下面可以支持下面指令

```sh
php think worker [start|stop|reload|restart|status]
```

- status: 状态
    - start: 启动
    - stop: 关闭
    - restart: 重启

- -d : 后台执行

## 文档

[TP6开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)  
[FormBuilder](http://php.form-create.com/)  
[Light Year Admin](http://www.itshubao.com/doc-lyear/lyear.html)  
[Workerman](http://doc.workerman.net/)  
[EasyWeChat](https://www.easywechat.com/docs)  

## 截图
![Image text](https://asset.leapy.cn/upload/image/20201219/1929fe8858061a55247f80d663e03866.png)

![Image text](https://asset.leapy.cn/upload/image/20201219/f07eb3ee03a10c8134e58280c6b498d7.png)

![Image text](https://asset.leapy.cn/upload/image/20201219/1eedff0f93f57eb679089207f76d8b36.png)

![Image text](https://asset.leapy.cn/upload/image/20201219/28757747c20d2d5e10899d3b509009f3.png)

![Image text](https://asset.leapy.cn/upload/image/20201219/f71acaa4cf5249bd651c78bdd22cbac9.png)

![Image text](https://asset.leapy.cn/upload/image/20201219/e38e26194d5d81a9cf5f5c465f01e979.png)

## 后台体验
后台地址 https://demo.kuzuozhou.cn/  
账号 admin  
密码 123456  

## 其它项目
[Sweet Girl 直播商城](https://gitee.com/leapy/sweet-girl) 

## 联系我
邮箱：cfn@leapy.cn  
微信：SH-CFN
## 版权信息

Pai-admin遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2019-2020 by LEAPY (https://demo.kuzuozhou.cn/)

All rights reserved。
