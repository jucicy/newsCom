<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\index\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class UserController extends Controller{

    public function login(){
        if(Request::instance()->isPost()){
            $username = trim(input('post.username'));
            $password = trim(input('post.password'));

            if($username == '' || $password == ''){
                return json(array('code'=>1,'msg'=>'用户名或密码必须填写'));
            }

            $userModel = new User();
            $result = $userModel->getUserDataByUsername($username);
            if(count($result)<1){
                return json(array('code'=>1,'msg'=>'用户名或密码错误'));

            }
            $userData = $result[0];
            if($userData['password'] != $password){
                return json(array('code'=>1,'msg'=>'密码错误'));
            }else{
                cookie('userData',['uid'=>$userData['uid'],'username'=>$userData['username']]);
                return json(array('code'=>0,'msg'=>'登陆成功'));
            }
        }
    }

    public function register(){
        if(Request::instance()->isPost()){
            $username = trim(input('post.username'));
            $password = trim(input('post.password'));
            $repassword = trim(input('post.repassword'));
//            $code = trim(input('post.code'));

            if($username == '' || $password == '' || $repassword == ''){
                return json(array('code'=>1,'msg'=>'用户名、密码、确认密码和验证码必须填写'));
            }

            if(mb_strlen($username)>20){
                return json(array('code'=>1,'msg'=>'用户名长度不能超过20个字符'));
            }

            if(strlen($password)>20){
                return json(array('code'=>1,'msg'=>'密码长度不能超过20个字符'));
            }

            if($password != $repassword){
                return json(array('code'=>1,'msg'=>'确认密码和密码不一样'));
            }

            $userModel = new User();
            $result = $userModel->getUserDataByUsername($username);
            if(count($result)>0){
                return json(array('code'=>1,'msg'=>'该用户名已经被注册'));
            }

            //todo：验证码验证
            $uid = $userModel->add($username, $password);
            cookie('userData',['uid'=>$uid,'username'=>$username]);

            return json(array('code'=>0,'msg'=>'注册成功'));
        }
    }

    //登出
    public function loginout(){
        cookie('userData',null);
        $this->success('成功登出，返回首页','/');
    }



}