<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\admin\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class IndexController extends Controller{

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
                if($userData['is_admin']){
                    session('adminData',['adminId'=>$userData['uid'],'username'=>$userData['username']]);
                    return json(array('code'=>0,'msg'=>'登陆成功'));
                }else{
                    return json(array('code'=>1,'msg'=>'不是管理员不允许登陆'));
                }
            }
        }else{
            return view('login');
        }
    }

    //登出
    public function loginout(){
        cookie('userData',null);
        $this->success('成功登出，若要进后台请登陆','/admin/index/login');
    }

}
