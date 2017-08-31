<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\common\model;

use think\Model;

class News extends Model{
    public function getAllNewsList(){
        $sql = 'select news.*, user.username from news left join user on user.uid = news.admin_id order by ntime desc';

        return $this->query($sql);
    }

    public function getAllUpNewsList(){
        $sql = 'select `nid`,`title`,`ntime` from news where status = 1';

        return $this->query($sql);
    }

    public function getNewsData($nid){
        $sql = "select news.*, user.username from news left join user on user.uid = news.admin_id where nid = $nid";

        return $this->query($sql);
    }

    public function getUpNewsData($nid){
        $sql = "select news.*, user.username from news left join user on user.uid = news.admin_id where nid = $nid and status = 1";

        return $this->query($sql);
    }

    public function add($title, $detail, $adminId){
        $this->title = $title;
        $this->detail = $detail;
        $this->admin_id = $adminId;
        $this->ntime = date('Y-m-d H:i:s',time());
        $this->status = 0;
        $this->save();
        return $this->nid;
    }

    public function edit($nid, $title, $detail){
        $sql = "update news set title = '$title', detail = '$detail' where nid = $nid";

        return $this->execute($sql);
    }

    public function deleteNews($nid){
        $sql = "delete from news where nid = $nid";

        return $this->execute($sql);
    }

    public function status($nid, $status){
        $sql = "update news set status = $status where nid = $nid";

        return $this->execute($sql);
    }



}