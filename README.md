JJPHP（Just Return JSON） 是一个基于BSD开源协议发布的，快速、简单的面向对象的 轻量级PHP开发框架。该项目主要用于Web服务应用，如手机客户端的Server端，所以本身不提供View。如果要View可以用JVPHP。主要特性：
1.基于MSC(Model、Service、Control)架构
2.数据访问基于NotORM(www.notorm.com)
3.集成了OAuth2
4.系统只是返回JSON
5.无需配置除了数据库
6.系统采用单例模式
7.提供了File、DB等种缓存机制
7.提供常用的类库如Curl、File、Http的等等

JJPHP开发框架永久开源和免费提供使用,域名 www.111work.com/jjphp/

JJPHP框架目录
|  
|  -config                      配置
|  |-JJDbConfig.php             数据库配置
|  |-JJCacheConfig.php          默认缓存配置
|  |-JJOAuthConfig.php          OAuth配置
|  
|  -core			框架核心
|  ├cache			缓存
|  ├comm			核心类
|  ├dao			数据访问
|  ├oauth	                oauth
|  ├util		        核心辅助类
|  ├JJPHP.php			最核心类
|
|  -lib                         常用类库
|  
|  -web                         项目目录
|  ├contrlib                   自定义controller
|  ├controller                 控制器类
|  ├model                      模型类数据访问层
|  ├service                    服务类
|  ├util                       项目辅助类
|
|  -index.php                   入口文件
 

部署说明:
1.数据库配置 配置文件在config/JJDbConfig.php下 填写相应的配置就可以了
2.缓存配置   如果要用缓存 请参考config/JJCacheConfig.php
3.oauth配置  请参考config/JJOAuthConfig.php
4.访问格式为 http://baseurl/index.php/controler-action.api
        或者 http://baseurl/index.php/controler-action
5.如果要用实例 请执行JJPHPTest.sql

