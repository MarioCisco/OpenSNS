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
        $lastId = I('get.lastid','intval',0);
        $news = M('News')->where(array('id' => array('gt',$lastId)))->select();
        if($news != null){
            $res = array(
                'status' => 1,
                'data' => $news
            );
        }else{
            $res = array(
                'status' => 0
            );
        }
        echo json_encode($res);
    }
    
} 