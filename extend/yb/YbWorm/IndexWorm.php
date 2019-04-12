<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-10
 * Time: 下午10:46
 */

namespace yb\YbWorm;

class IndexWorm
{

    /**
     * @var HttpClient
     */
    protected $request;

    public function __construct()
    {
        $this->request = HttpClient::instance();
    }

    /**
     * 获取易班首页
     * @return string
     */
    public function getIndexPage(){
        return $this->request->get(config('yb.host'))->getBody()->getContents();
    }

    public function topArticleList(){
        $page = $this->getIndexPage();

    }
}