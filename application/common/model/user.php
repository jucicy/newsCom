<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\common\model;

use think\Db;
use think\Model;

class User extends Model{

    public function add($username, $password, $isAdmin=0){
        /*$sql =  "insert into user (username, password, is_admin) VALUE ($username, $password, $isAdmin) ";
        return $this->execute($sql);*/

        $this->username = $username;
        $this->password = $password;
        $this->is_admin = $isAdmin;
        $this->save();
        return $this->uid;
    }

    public function updatePassword($uid, $password){
        if($password){
            $sql =  "update user set password = $password where uid = $uid";
            return $this->execute($sql);
        }else{
            return false;
        }
    }

    public function setAdmin($uid, $isAdmin=1){
        $sql =  "update user set is_admin = $isAdmin where uid = $uid";
        return $this->execute($sql);
    }

    public function getUserDataById($uid){
        $sql =  "select * from user where uid = $uid";
        return $this->query($sql);
    }

    public function getUserDataByUsername($username){
        $sql =  "select * from user where username = :username";
        return Db::query($sql,['username'=>$username]);
    }

}