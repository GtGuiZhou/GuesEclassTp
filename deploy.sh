#!/usr/bin/env bash
echo '开始执行部署脚本'
# 可以使用下面的指令生成类库映射文件，提高系统自动加载的性能。
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
