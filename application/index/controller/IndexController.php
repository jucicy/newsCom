<?php
namespace app\index\controller;

use app\common\model\Comment;
use app\common\model\News;
use think\Controller;

class IndexController extends Controller{
    public function index(){
        $newsModel = new News();
        $newsList = $newsModel->getAllUpNewsList();

        $userData = cookie('userData');

        return view('index', ['newsList' => $newsList,'userData'=>$userData]);
    }

    public function detail1(){
        $nid = $username = input('get.nid');
        if(!$nid){
            $this->error('链接错误，返回首页','/');
        }

        $newsModel = new News();
        $result = $newsModel->getUpNewsData($nid);
        if(count($result)<1){
            $this->error('该新闻不存在，返回首页','/');
        }

        $commentModel = new Comment();
        $commentList = $commentModel->getAllCommentByNid($nid);

        $userData = cookie('userData');

        return view('detail', ['newsData'=>$result[0],'userData'=>$userData,'commentList'=>$commentList]);
    }

    public function detail(){
        $nid = $username = input('get.nid');
        if(!$nid){
            $this->error('链接错误，返回首页','/');
        }

        $newsModel = new News();
        $result = $newsModel->getUpNewsData($nid);
        if(count($result)<1){
            $this->error('该新闻不存在，返回首页','/');
        }

        $userData = cookie('userData');

        return view('detail', ['newsData'=>$result[0],'userData'=>$userData]);
    }

    public function upload(){
        return view('upload');
    }

    public function uploadCsv(){
        $file = $_FILES;

        print_r($file);
//        exit;

        $insertCouponNumberArr = [];
        if (($handle = fopen($file['file']['tmp_name'], "r")) !== FALSE) {
            $key = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                if(is_numeric($data[0])&&$data[0]>120006){
                    $insertCouponNumberArr[$key] = $data;
                    $key++;
                }
            }
            fclose($handle);

            print_r($insertCouponNumberArr);
        }
    }

}
