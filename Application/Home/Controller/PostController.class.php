<?php

/**
 * @author Zhou Yuyang <1009465756@qq.com> 12:28 2016/1/23
 * @copyright 2105-2018 SRCMS 
 * @homepage http://www.src.pw
 * @version 1.5
 */

namespace Home\Controller;

use Think\Controller;

class PostController extends Controller{

    public function index($key="")
    {
	   if($key == ""){
            $model = M('post');  
        }else{
            $where['title'] = array('like',"%$key%");
            $where['name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('post')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Post = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Post->show();// 分页显示输出
        $pages = $model->limit($Post->firstRow.','.$Post->listRows)->where($where)->where('visible=1')->order('id DESC')->select();
		$tmodel= M('setting');
		$title = $tmodel->where('id=1')->select();
        $this->assign('title', $title);
        $this->assign('model', $pages);
        $this->assign('page',$show);
        $this->display();     
    }


    public function view(){
		$id = I('get.id',0,'intval');    //对传入数字参数做整数校验，规避SQLinjection漏洞
        $model = M('post')->where('id='.$id)->where('visible=1')->find();
		$tmodel= M('setting');
		$title = $tmodel->where('id=1')->select();
        $this->assign('title', $title);
        $this->assign('model',$model);
        $this->display();
    }
}
