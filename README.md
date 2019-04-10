## 易班授权对接时出现无效的应用端回调地址
```
// 即如下的响应，是因为配置填写的回调地址错误，应该填写的是易班的站内地址
// 易班的站内地址：http://f.yiban.cn/iapp321470（类似）
{"code":"e002","msgCN":"\u65e0\u6548\u7684\u5e94\u7528\u7aef\u56de\u8c03\u5730\u5740","msgEN":""}
```
## GuzzleHttp发送表单的正确姿势
```
$this->client->post('default2.aspx',['form_params'=>$data])->getBody()
```
## 代码迁移或部署须知
1.如果需要迁移含有redirect方法的代码，需要注意，我已经将本项目的伪静态后缀设为空，因为他会导致使用redirect函数会自动加上.html的后缀，而我不需要。(设置位置/application/config/app.url_html_suffix)


## 快速生成代码的命令
### 创建
```php
php think crud test
```
执行上面这一行命令会创建如下的文件，并且每个文件内部都写了一些模板代码，只是替换了名字而已。
- application\admin\controller\TestController
- application\api\controller\TestController
- application\common\model\TestModel
- application\common\validate\TestValidate
- route\test
#### 模块名称建议使用驼峰命名法
以`php think crud test`做讲解，其中test为模块名称，它对应sys_text的数据库表名，如果你的表面为sys_xx_xx请使用驼峰命名法。
例如：数据库表名为sys_love_wall那么你应该执行`php think crud loveWall`
### 删除
```php
php think crud test -d 1
```
执行上面这一行命令会删除如下的文件
- application\admin\controller\TestController
- application\api\controller\TestController
- application\common\model\TestModel
- application\common\validate\TestValidate
- route\test
### 模型附加软删除功能
```php
php think crud test -s 1
```
### 路由附加向请求参数注入当前用户id功能
```php
php think crud test -b 1
```

## 人人墙模块原理
- 用户客户端提交评论数据-》后端中间件将数据保存在redis中，并设定key的过期时间，一般是5s过期-》保存到评论表里面
- 播放弹幕客户端获取评论数据-》后端将最近n条数据返回
tip:设定key过期时间是为了保证，用户不发评论，那么到了过期时间，播放客户端就没有数据了
tip:如果redis中的评论数量超过n条就会在插入redis数据前，先清空弹幕数据。
tip:具体配置在config/humanwall里面
