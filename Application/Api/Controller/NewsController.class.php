<?php

namespace Api\Controller;

use Think\Controller;

/**
 * 新闻客户端API接口
 * @package Api\Controller
 */
class NewsController extends Controller{


    /**
     * 下拉刷新获得最新数据
     */
    public function getLatestNews(){
        $count = I('post.count','intval',0);

    }

} 