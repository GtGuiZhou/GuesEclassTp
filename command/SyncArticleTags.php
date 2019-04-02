<?php

namespace app\command;

use app\common\ext\RedisPool;
use app\common\model\ArticleModel;
use app\common\model\SysConfigModel;
use Exception;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Log;

class SyncArticleTags extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('app\command\sync_article_tags');
        // 设置参数

    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        $key = 'article:tags';
        $redis = RedisPool::instance();
        // 将mysql中的标签先同步到redis中
        try{
            $tagsModel = ArticleModel::field('tags')->select();
            $tags = [];
            foreach ($tagsModel as $model){
                $tags = array_merge($tags,$model['tags']);
            }
            $redis->sAddArray($key,$tags);
            $tags = $redis->sMembers($key);
            $config = new SysConfigModel();
            $config = $config->where('field',$key)->findOrFail();
            $config->save(['value' => $tags]);
//            SysConfigModel::where('field',$key)->update(['value' => $tags]);
            $output->writeln('同步文章标签完成');
            Log::notice('同步文章标签完毕');
        } catch (Exception $e){
            Log::error("同步文章标签失败:".$e->getMessage());
            $output->writeln($e->getMessage());
        }
    }
}
