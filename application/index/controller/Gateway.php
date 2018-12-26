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
class Gateway extends  Controller
{
    public  function  index(){

        return $this->fetch();
    }
    public function  test(){
        $array  = ['预言家','女巫','猎人','狼人','白狼王','村民'];
    }
}