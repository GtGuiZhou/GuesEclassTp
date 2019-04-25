<?php


\think\facade\Route::rule('api/index/indexall','api/index/indexall')
    ->cache(config('cache.index_list')); // 缓存5分钟