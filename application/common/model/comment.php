<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\common\model;

use think\Model;

class Comment extends Model{
    public function add($uid, $content, $nid){
        /*$sql =  "insert into user (username, password, is_admin) VALUE ($username, $password, $isAdmin) ";
        return $this->execute($sql);*/

        $this->uid = $uid;
        $this->content = $content;
        $this->ctime = date('Y-m-d H:i:s',time());
        $this->nid = $nid;
        $this->save();
        return $this->cid;
    }

    public function getAllCommentByNid($nid){
        $sql = "select user.`uid`,user.`username`,`content`,`ctime`,`nid` from comment left join user on user.uid = comment.uid where `nid` = $nid order by ctime DESC ";

        return $this->query($sql);
    }

    public function getPageCommentByNid($nid, $from, $length){
        $sql = "select user.`uid`,user.`username`,`content`,`ctime`,`nid` from comment left join user on user.uid = comment.uid where nid = $nid  order by ctime DESC limit $from, $length ";
        return $this->query($sql);
    }

    public function getCommentCountByNid($nid){
        $sql = "select COUNT(*) as totalCount from comment where nid = $nid ";

        return $this->query($sql);
    }




}