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
1.如果需要迁移含有redirect方法的代码，需要注意，我已经将本项目的伪静态后缀设为空，因为使用redirect函数会自动加上.html的后缀，而我不需要。

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
