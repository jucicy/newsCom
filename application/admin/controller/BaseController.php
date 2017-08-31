<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
namespace app\admin\controller;

use think\Controller;

class BaseController extends Controller{
    //管理员户是否登陆，是否是管理员验证
    public function __construct(){
        $adminData = session('adminData');

        if(!$adminData){
            $this->error('未登录，先登陆','admin/index/login');
        }

    }
}

