<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
class Index extends  Controller
{
    public function index(Request $request)
    {

        return $this->fetch();
    }
    public  function  test(){
        $array  = ['预言家','女巫','猎人','守卫','狼人','白狼王','村民'];
         $pai =[];
        for ($i=0;$i<1000;$i++){
            if(count($pai)<=7){
                $r = rand(0,7);
                if(!empty($array[$r])){
                    $pai[]= $array[$r];
                    echo $array[$r]."        ";
                    var_dump($array[$r]);
                    unset($array[$r]);
                }
            }
        }

    }
    public  function  dd(){
     //   $dd=1;
       // echo isset($dd);
      // $id =  mb_substr("玩家:  刀03",strpos("玩家:  刀03",'刀')+1,1,"utf-8");
    //    echo  $id;
     //   echo mb_substr("毒03 玩家 ",strpos("毒03 玩家 ",'毒')-6,2,"utf-8");
        echo "<pre/>";
        $array = array('01','02');

        $data = [];
        foreach ($array as $str) {

            @$result[$str] = $result[$str] + 1;
        }
        foreach ($result as $k=>$v){
            if($v == max($result)){
                $data[]= $k;
            }
        }

//        $repeat_arr = array_diff_assoc ( $result, max($result) );
//        print_r($repeat_arr);
//        echo array_search(max($result),$result);
        print_r($data);

        //echo mb_substr("玩家投02",strpos("玩家投02 ",'投')-3,2,"utf-8");
    }

}
