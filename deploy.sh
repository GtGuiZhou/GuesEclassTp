#!/usr/bin/env bash
return # 先停止使用部署脚本
echo '安装包'
composer install
echo '开始执行部署脚本'
# 可以使用下面的指令生成类库映射文件，提高系统自动加载的性能。
echo '清空缓存' # 注意：redis中的缓存无法被清除
php think clear
echo '生成类库映射文件...'
php think optimize:autoload
# 生成配置缓存文件
echo '生成配置缓存文件...'
php think optimize:config
# 生成数据表字段信息缓存，提升数据库查询的性能，避免多余的查询
echo '生成数据表字段信息缓存...'
php think optimize:schema
# 生成路由映射缓存的命令
echo '生成路由映射缓存...'
php think optimize:route

# 自定义命令
echo '修改当前目录所有文件的所属权限'
chown -R www:www ./ # 防止出现其它用户运行当前脚本改变文件的所属权限

# 由于阿里云封禁了25端口，因此让学校的服务器来发送邮件（暂时无法使用）
#if [  -d "/opt/eclass" ];then
#    echo '启动定时器任务'
#    nohup php think timer >> runtime/log/timer.log 2>&1 &
#fi

echo '所有操作都已经执行完毕'