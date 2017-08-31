<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\index\controller;

use app\common\model\Comment;
use think\Controller;
use think\Request;

class CommentController extends Controller{
    public function add(){
        if (Request::instance()->isPost()) {
            $uid = trim(input('post.uid'));
            $content = trim(input('post.content'));
            $nid = trim(input('post.nid'));

            if ($content == '') {
                return json(array('code' => 1, 'msg' => '评论内容必须填写'));
            }

            $commentModel = new Comment();
            $commentModel->add($uid, $content, $nid);

            return json(array('code'=>0,'msg'=>'评论成功'));
        }
    }

    public function getPageCommentList(){
        $nid = trim(input('get.nid'));
        $page = trim(input('get.page'));
        $limit = trim(input('get.limit'));

        $commentModel = new Comment();
        $commentList = $commentModel->getPageCommentByNid($nid, ($page-1)*$limit, $limit);
        $count = $commentModel->getCommentCountByNid($nid)[0]['totalCount'];

        return json(array('code'=>0,'commentList'=>$commentList,'count'=>$count,'page'=>$page,'limit'=>$limit));
    }


}