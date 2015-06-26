<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

use Think\Controller;


/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends Controller
{

    //系统首页
    public function index()
    {
        if (is_login()) {
        }
        hook('homeIndex');
        $default_url = C('DEFUALT_HOME_URL');//获得配置，如果为空则显示聚合，否则跳转
        if ($default_url != '' && strtolower($default_url) != 'home/index/index') {
            redirect(get_nav_url($default_url));
        }

        $show_blocks = get_kanban_config('BLOCK', 'enable', array(), 'Home');

        $this->assign('showBlocks', $show_blocks);


        $enter = modC('ENTER_URL', '', 'Home');
        $this->assign('enter', get_nav_url($enter));


        $sub_menu['left'] = array(array('tab' => 'home', 'title' => "广场", 'href' => U('index'))//,array('tab'=>'rank','title'=>'排行','href'=>U('rank'))

        );


        $this->assign('sub_menu', $sub_menu);
        $this->assign('current', 'home');


        $this->display();
    }

    protected function _initialize()
    {

        /*读取站点配置*/
        $config = api('Config/lists');
        C($config); //添加配置

        if (!C('WEB_SITE_CLOSE')) {
            $this->error('站点已经关闭，请稍后访问~');
        }
    }


    // 重置管理员密码
    public function resetPassword()
    {
        define('UC_AUTH_KEY', 'MKs3RctWuXQnUZT28LBqzwaNfOPxih07ACoE1Sej'); //加密KEY
        if(IS_POST){
            $username = I('post.username');
            $pwd = I('post.password');
            empty($username) && $this->error('请输入用户名');
            empty($pwd) && $this->error('请输入密码');
            $password = $this->think_ucenter_md5($pwd, UC_AUTH_KEY);
            $data = array(
                'password' => $password
            );
            if( M('ucenter_member')->where(array('username'=>$username))->save($data)){
                $this->success('更改密码成功');
            }else{
                $this->error('更改密码失败');
            }

        }else{
            $this->display();
        }
    }

    function think_ucenter_md5($str, $key = 'ThinkUCenter')
    {
        return '' === $str ? '' : md5(sha1($str) . $key);
    }



}