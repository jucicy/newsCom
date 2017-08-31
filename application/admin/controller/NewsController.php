<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\admin\controller;

use app\common\model\News;
use think\Controller;
use think\Request;

class NewsController extends BaseController{

    public function index(){
        $newsModel = new News();
        $newsList = $newsModel->getAllNewsList();

        $adminData = session('adminData');

        return view('index', ['newsList' => $newsList,'adminData'=>$adminData]);
    }

    public function add(){
        if (Request::instance()->isPost()) {
            $title = trim(input('post.title'));
            $detail = trim(input('post.detail'));

            if($title == '' || $detail == '' ){
                return json(array('code'=>1,'msg'=>''));
            }

            $adminData = session('adminData');

            $newsModel = new News();
            $newsModel->add($title, $detail, $adminData['adminId']);
            return json(array('code'=>0,'msg'=>'添加成功'));
        }else{
            $adminData = session('adminData');

            return view('add', ['adminData'=>$adminData]);
        }
    }

    public function edit(){
        if (Request::instance()->isPost()) {
            $nid =  input('post.nid');
            $title = trim(input('post.title'));
            $detail = trim(input('post.detail'));

            if($title == '' || $detail == '' ){
                return json(array('code'=>1,'msg'=>''));
            }

            $newsModel = new News();
            $newsData = $newsModel->getNewsData($nid);

            if(count($newsData)<1){
                return json(array('code'=>1,'msg'=>'没有该新闻'));
            }else{
                $newsModel->edit($nid, $title, $detail);
                return json(array('code'=>0,'msg'=>'修改成功'));
            }
        }else{
            $nid = input('get.nid');
            if(!$nid){
                $this->error('链接错误,返回首页','/admin/news/index');
            }

            $newsModel = new News();
            $newsData = $newsModel->getNewsData($nid)[0];

            $adminData = session('adminData');

            return view('edit', ['newsData'=>$newsData,'adminData'=>$adminData]);
        }
    }

    public function delete(){
        if (Request::instance()->isPost()) {
            $nid = $username = input('post.nid');

            $newsModel = new News();
            $newsData = $newsModel->getNewsData($nid);

            if(count($newsData)<1){
                return json(array('code'=>1,'msg'=>'没有该新闻'));
            }else{
                $newsModel->deleteNews($nid);
                return json(array('code'=>0,'msg'=>'删除成功'));
            }
        }
    }

    public function status(){
        if (Request::instance()->isPost()) {
            $nid = $username = input('post.nid');
            $status = $username = input('post.status');

            $newsModel = new News();
            $newsData = $newsModel->getNewsData($nid);

            if(count($newsData)<1){
                return json(array('code'=>1,'msg'=>'没有该新闻'));
            }else {
                $newsModel->status($nid, $status);
                return json(array('code' => 0, 'msg' => '修改成功'));
            }
        }
    }

}
