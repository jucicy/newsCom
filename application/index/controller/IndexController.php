<?php
namespace app\index\controller;


use think\Controller;
use think\View;

class IndexController extends Controller{
    public function index(){

        return view('index', ['username' => 'test']);
    }
}
