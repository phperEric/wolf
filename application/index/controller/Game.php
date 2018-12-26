<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/5 0005
 * Time: 10:56
 */

namespace app\index\controller;
use think\Db;
use think\Controller;
class Game extends  Controller
{
    public  function  index(){
        $zf =  Db::table('game')->where('game_uid',1)->find();
        $this->assign("data",$zf);
        return $this->fetch();
    }
    public function  test(){
        $data =  Db::table('game')->find();
        print_r($data);
    }
}