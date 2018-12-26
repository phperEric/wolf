<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
require_once  'D:/phpstudy/PHPTutorial/WWW/tp5/vendor/workerman/Workerman/Lib/Timer.php';
require_once  'D:/phpstudy/PHPTutorial/WWW/tp5/vendor/autoload.php';

//require_once __DIR__ . '/vendor/workerman/mysql/src/Connection.php';
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {

        global $db;

        $str = "";
        // 执行SQL

        $data= $db->select('*')->from('game')->row();
        $updata =[];
        if(empty($data['game_uid1'])){
            $updata['game_uid1'] = substr($client_id,-2);
            $str = '1';
        }
        elseif(empty($data['game_uid2'])){
            $updata['game_uid2'] = substr($client_id,-2);
            $str = '2';
        }
        elseif(empty($data['game_uid3'])){
            $updata['game_uid3'] = substr($client_id,-2);
            $str = '3';
        }
        elseif(empty($data['game_uid4'])){
            $updata['game_uid4'] = substr($client_id,-2);
            $str = '4';
        }
        elseif(empty($data['game_uid5'])){
            $updata['game_uid5'] = substr($client_id,-2);
            $str = '5';
        }
        elseif(empty($data['game_uid6'])){
            $updata['game_uid6'] = substr($client_id,-2);
            $str = '6';
        }
        else{
            $updata['game_uid7'] = substr($client_id,-2);
            $str = '7';
        }
        $db->update('game')->cols($updata)->where('game_id=1')->query();
        $_SESSION['id'] = $client_id;
        $_SESSION['str'] = $str;



        // 给connection对象临时添加一个timer_id属性保存定时器id
        $time_interval = 10;
        global $tianhei; //天黑时间
        global $a; //狼人刀时间
        global $b; //女巫
        global $c; //预言家
        global $d; //守卫
        global $bai1; //白天1
        global $bai2; //白天2

        global $du; //女巫毒药
        global $jiu; //女巫救人
        $du = 1;
        $jiu = 1;

        global  $nvstate;//女巫能否用药
        global  $yu;//预言家天黑查验
        global  $lang;//狼人天黑刀人
        $nvstate = false;

        $yu = false;

        $lang = false;

        $tianhei= 0;
        $a=1;
        $b=0;
        $c=0;
        $d=0;
        $bai1=0;
        $bai2=0;
        \Workerman\Lib\Timer::add(1, function ($client_id,$db,$a,$b,$c,$d,$bai1,$bai2) {
            $data= $db->select('*')->from('game')->row();
            $user = Gateway::getAllClientSessions();
            $id = array_keys($user);
            if($data['game_fstate']==1&&$GLOBALS['tianhei']!=-1){

                    $GLOBALS['tianhei']++;

                    if($GLOBALS['tianhei']<=150&&$GLOBALS['tianhei']>=0) {

                        if($GLOBALS['tianhei'] < 60){
                            $GLOBALS['a']++;
                        if ($GLOBALS['a'] == 3&&$GLOBALS['tianhei'] < 60) {
                            $GLOBALS['lang']  = true;
                            if ($data['game_state1'] == "狼人") {
                               // Gateway::sendToClient($id[0], 'heiye1,狼人请输入要\'刀\'的玩家');
                                Gateway::joinGroup($id[0], '狼人');
                            }
                            if ($data['game_state2'] == "狼人") {
                               // Gateway::sendToClient($id[1], 'heiye1,狼人请输入要\'刀\'的玩家');
                                Gateway::joinGroup($id[1], '狼人');
                            }
                            if ($data['game_state3'] == "狼人") {
                               // Gateway::sendToClient($id[2], 'heiye1,狼人请输入要\'刀\'的玩家');
                                Gateway::joinGroup($id[2], '狼人');
                            }

                            Gateway::sendToGroup('狼人','heiye1,狼人请输入要\'刀\'的玩家');

                            }

                        }
                        if ($GLOBALS['tianhei'] >= 60 && $GLOBALS['tianhei'] <= 90) {

                            $GLOBALS['a'] = 0;
                            $GLOBALS['b']++;
                            if ($GLOBALS['b'] == 3) {
                                $GLOBALS['lang']  = false;
                                $GLOBALS['nvstate']  = true;
                                Gateway::sendToGroup('狼人','heiye1,狼人刀人时间到！');
                                if(empty($GLOBALS['lang1'])){
                                    $GLOBALS['lang1']= '无人';
                                }
                                if ($data['game_state1'] == "女巫") {

                                    Gateway::sendToClient($id[0], 'heiye1,'.'今晚，'.$GLOBALS['lang1'].'死亡，女巫请输入用毒药或解药');
                                }
                                if ($data['game_state2'] == "女巫") {

                                    Gateway::sendToClient($id[1], 'heiye1,'.'今晚，'.$GLOBALS['lang1'].'死亡，女巫请输入用毒药或解药');

                                }
                                if ($data['game_state3'] == "女巫") {
                                    Gateway::sendToClient($id[2], 'heiye1,'.'今晚，'.$GLOBALS['lang1'].'死亡，女巫请输入用毒药或解药');
                                    //Gateway::sendToClient($id[2], 'heiye1,女巫请输入用毒药或解药');
                                }

                            }
                        }

                        if ($GLOBALS['tianhei'] > 90 && $GLOBALS['tianhei'] <= 120) {

                            $GLOBALS['b'] = 0;
                            $GLOBALS['c']++;

                            if ($GLOBALS['c'] == 3) {
                                $GLOBALS['nvstate']  = false;
                                $GLOBALS['yu']  = true;

                                if ($data['game_state1'] == "预言家") {
                                    Gateway::sendToClient($id[0], 'heiye1,预言家请输入要查验的玩家');
                                }
                                if ($data['game_state2'] == "预言家") {
                                    Gateway::sendToClient($id[1], 'heiye1,预言家请输入要查验的玩家');
                                }
                                if ($data['game_state3'] == "预言家") {
                                    Gateway::sendToClient($id[2], 'heiye1,预言家请输入要查验的玩家');
                                }

                            }
                        }
                        if ($GLOBALS['tianhei'] > 120 && $GLOBALS['tianhei'] <= 150) {

                            $GLOBALS['c'] = 0;
                            $GLOBALS['d']++;

                            if ($GLOBALS['d'] == 3) {
                                $GLOBALS['yu']  = false;
                                if ($data['game_state1'] == "守卫") {
                                    Gateway::sendToClient($id[0], 'heiye1,守卫请输入要守护的玩家');
                                }
                                if ($data['game_state2'] == "守卫") {
                                    Gateway::sendToClient($id[1], 'heiye1,守卫请输入要守护的玩家');
                                }
                                if ($data['game_state3'] == "守卫") {
                                    Gateway::sendToClient($id[2], 'heiye1,守卫请输入要守护的玩家');
                                }
                            }
                        }
                    }
                  if($GLOBALS['tianhei']>150){
                      if($GLOBALS['tianhei']==152){
                          $user = Gateway::getAllClientSessions();
                          $sid = array_keys($user);
                          foreach ($sid as $v){
                              if(substr($v,-2)==$GLOBALS['lang1']){
                                  $db->query("UPDATE `game` SET game_state".$user[$v]['str']."=''   WHERE `game_id` = 1");
                              }
                              if(substr($v,-2)==$GLOBALS['nv']){
                                  $db->query("UPDATE `game` SET game_state".$user[$v]['str']."=''   WHERE `game_id` = 1");
                              }
                          }
                      }
                    if($GLOBALS['tianhei']==160){



                        $sum=0;
                        $wan1= "";
                        $wan2="";
                      for ( $i=1;$i<4;$i++){

                            if($data['game_state'.(string)$i]==''){
                                if($wan1==""){
                                    $wan1= $data['game_uid'.(string)$i];
                                }else{
                                    $wan2= $data['game_uid'.(string)$i];
                                }
                                $sum++;
                            }
                        }
                        if($sum==0){
                            Gateway::sendToAll("昨天平安夜");
                        }else{
                            if(array_search("狼人",$data)) {
                                if ($sum == 1) {
                                    Gateway::sendToAll("昨天" . $sum . '人死亡' . $wan1);
                                } else {
                                    Gateway::sendToAll("昨天" . $sum . '人死亡，' . $wan1 . '和' . $wan2);
                                }
                                $sum = 0;
                            }
                            else{
                                $GLOBALS['tianhei']= -1;
                                Gateway::sendToAll("游戏结束");
                            }
                        }

                    }
                    if($GLOBALS['tianhei']==420){
                        Gateway::sendToAll("所有玩家开始投票，'投'");
                        }
                        if($GLOBALS['tianhei']==440){
                            $data = [];
                            foreach ($GLOBALS['tou'] as $str) {

                                @$result[$str] = $result[$str] + 1;
                            }
                            foreach ($result as $k=>$v){
                                if($v == max($result)){
                                    $data[]= $k;
                                }
                            }
                            if(count($data)==1){
                                $user = Gateway::getAllClientSessions();
                                $sid = array_keys($user);
                                foreach ($sid as $v){
                                    if(substr($v,-2)==$data[0]){
                                        $db->query("UPDATE `game` SET game_state".$user[$v]['str']."=''   WHERE `game_id` = 1");
                                    }
                                }
                            }
                            else{
                                $str ="";
                                foreach ($data as $v){
                                    $str .=$v.'、  ';
                                }
                                $GLOBALS['tianhei'] =400;
                                    Gateway::sendToAll($str.'平票，再次发言');
                            }
                        }
                        if($GLOBALS['tianhei']==445){

                            if(array_search("狼人",$data)){


                            $user = '所剩余玩家：';
                            for ( $i=1;$i<4;$i++){
                                if($data['game_state'.(string)$i]!=''){
                                    $user .= $data['game_uid'.(string)$i]."、        ";
                                }
                            }
                            $user .="<br/>进入白天";
                            }else{
                                $user = "游戏结束";
                                $GLOBALS['tianhei']= -1;
                            }

                            Gateway::sendToAll($user);
                        }
                  }
                    if($GLOBALS['tianhei']>450){
                        $GLOBALS['tianhei'] = 0;
                    }

            }
        }, array($client_id,$db,$a,$b,$c,$d,$bai1,$bai2), true);

        Gateway::sendToAll('login,'.substr($_SESSION['id'],-2).','. $_SESSION['str']);
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onWorkerStart()
    {
            global $db;
            global $tianhei; //天黑时间
            global $a; //狼人刀时间
            global $b; //女巫
            global $c; //预言家
            global $d; //守卫
            global $bai1; //白天1
            global $bai2; //白天2

            global $du; //女巫毒药
            global $jiu; //女巫救人
        $du = 1;
        $jiu = 1;
             global  $nvstate;//女巫能否用药
          global  $yu;//预言家天黑查验
            global  $lang;//狼人天黑刀人

            global  $lang1;
            global  $lang2;
            global  $nv;  //使用药的玩家名称
            global   $tou;
            $db = new \Workerman\MySQL\Connection('127.0.0.1', '3306', 'root', 'root', 'game');


    }
    public static function onMessage($client_id, $message)
    {

        global $db;
        global  $lang1;
        global  $lang2;
        global  $nv;
        global   $tou;

        global $du; //女巫毒药
        global $jiu; //女巫救人
        global  $nvstate;//女巫能否用药
        global  $yu;//预言家天黑查验
        global  $lang;//狼人天黑刀人

        $array  = ['预言家','女巫','猎人','狼人','白狼王','村民'];

        $resData = explode(",",$message);
        $type = $resData[0];
        switch ($type) {
            case 'user':  // 用户发言

                if($resData[1] == "gameok"){
                    $user = Gateway::getAllClientSessions();

                    $sid = array_keys($user);
                    $data= $db->select('*')->from('game')->where('game_uid'. $_SESSION['str'].'='.substr($client_id,-2))->row();
                    Gateway::sendToClient($client_id, "pai,".substr($client_id,-2)."        牌:".$data['game_state'.$_SESSION['str']]);
                    Gateway::sendToClient($client_id,"玩家一：".substr($sid[0],-2)."       玩家二：".substr($sid[1],-2)."     玩家三：".substr($sid[2],-2));
                }
                else{
                    Gateway::sendToAll("user,".substr($client_id,-2).$resData[1]);
                }
                break;
            case 'game':
                    if($_SESSION['str'] =='1'){
                        $db->query("UPDATE `game` SET game_state1='1'  WHERE `game_id` = 1");
                    }if($_SESSION['str'] =='2'){
                $db->query("UPDATE `game` SET game_state2='1'   WHERE `game_id` = 1");
            }if($_SESSION['str'] =='3'){
                $db->query("UPDATE `game` SET game_state3='1'   WHERE `game_id` = 1");
            }if($_SESSION['str'] =='4'){
                $db->query("UPDATE `game` SET game_state4='1'   WHERE `game_id` = 1");
            }if($_SESSION['str'] =='5'){
                $db->query("UPDATE `game` SET game_state5='1'   WHERE `game_id` = 1");
            }if($_SESSION['str'] =='6'){
                $db->query("UPDATE `game` SET game_state6='1'   WHERE `game_id` = 1");
            }if($_SESSION['str'] =='7'){
                $db->query("UPDATE `game` SET game_state7='1'   WHERE `game_id` = 1");
            }
                $data= $db->select('*')->from('game')->row();
                    if($data['game_state1']==1&&$data['game_state2']==1&&$data['game_state3']==1){
                        //$array  = ['预言家','女巫','猎人','守卫','狼人','白狼王','村民'];
                        $array  = ['预言家','狼人','女巫'];
                        $pai =[];
                        $j ="0";
                        for ($i=0;$i<1000;$i++){
                            if(count($pai)<=3){
                                $r = rand(0,4);
                                if(!empty($array[$r])){
                                    $pai[]= $array[$r];
                                    $j ++;
                                    $j = (string)$j;
                                    $ziduan  = 'game_state'.$j;
                                    $db->query("UPDATE `game` SET ".$ziduan."='".$array[$r]."'   WHERE `game_id` = 1");
                                    unset($array[$r]);
                                }
                            }
                        }
                        $db->query("UPDATE `game` SET game_fstate=1   WHERE `game_id` = 1");

                      // Gateway::sendToClient($client_id, "        牌:1");
                        Gateway::sendToAll("gameok,".'所有玩家已准备 游戏开始！');
                    }
                    else{
                        Gateway::sendToAll("game,".substr($client_id,-2).'已准备！');
                    }
                break;
            case 'gameok2':  // 用户发言
               if($resData[1]=='lang'){
                   $id = mb_substr($resData[2],strpos($resData[2],'刀')-3,2,"utf-8");
                   $user = Gateway::getAllClientSessions();
                   $sid = array_keys($user);
                   foreach ($sid as $v){
                       if(substr($v,-2)==$id){
                           empty($lang1)?$lang1=substr($v,-2): (empty($lang2)?$lang2= substr($v,-2): $lang2);
                       }
                   }
                 //  Gateway::sendToGroup('狼人','gameok2,'.substr($client_id,-2).$resData[2]);
                   Gateway::sendToGroup('狼人','gameok2,'.substr($client_id,-2).$resData[2]);
               }
               else {

                   if (strpos($resData[1], '救') !== false || strpos($resData[1], '毒') !== false) {

                       if ($GLOBALS['nvstate']) {

                           if (strpos($resData[1], '毒') !== false) {
                               if($du==1){
                               $nv = mb_substr($resData[1], strpos($resData[1], '毒') - 6, 2, "utf-8");
                                   Gateway::sendToClient($client_id, "你选择了" . $resData[1]);
                                   $du-=1;
                               }else{
                                   Gateway::sendToClient($client_id, "毒药用完");
                               }
                           }else {
                               if($jiu ==1){
                                   $lang1 = '';
                                   $jiu-=1;
                                   Gateway::sendToClient($client_id, "你选择了" . $resData[1]);
                               }else{
                                   Gateway::sendToClient($client_id, "解药用完");
                               }

                           }

                       }
                       else {
                           Gateway::sendToClient($client_id, "未到用药时间");
                       }
                   }
                   else{

                       if($GLOBALS['yu']==1){
                       $data= $db->select('*')->from('game')->row();
                       $info =  mb_substr($resData[1],strpos($resData[1],'查')+1,2,"utf-8");
                       $state = "";
                       $user = Gateway::getAllClientSessions();
                       $sid = array_keys($user);
                       foreach ($sid as $v){
                           if(substr($v,-2)==$info){

                               if($data['game_state'.$user[$v]['str']]!='狼人'){

                                   $state= '好人';
                               }
                               else{
                                   $state = '狼人';
                               }
                           }
                       }    $GLOBALS['yu']+=1;
                            Gateway::sendToClient($client_id,"他是".$state);

                       }
                       elseif ($GLOBALS['yu']==2){
                           Gateway::sendToClient($client_id,"夜晚只能查验一次");
                       }

                       else{
                           Gateway::sendToClient($client_id,"未到查验时间");
                       }
                   }


               }
                break;
            case 'gameok3':  // 用户发言
                $uid =  mb_substr($resData[1],strpos($resData[1],'投')-3,2,"utf-8");
                $tou[] = $uid;
                Gateway::sendToAll(substr($client_id,-2).$resData[1]);
                break;
            default:
                //Gateway::sendToAll($client_id,$json_encode($resData));
                break;
        }
    }
    public static function onClose($client_id)
    {
        global  $db;
        // 广播 xxx logout
        $ziduan1  = 'game_state'.$_SESSION['str'];
        $ziduan2  = 'game_uid'.$_SESSION['str'];
        $db->update('game')->cols(array($ziduan1=>'',$ziduan2=>'','game_fstate'=>''))->where('game_id=1')->query();

        //$db->query("UPDATE `game` SET ".$ziduan."=''   WHERE `game_id` = 1");
        GateWay::sendToAll("eixt,".substr($client_id,-2)." 退出房间\n");
    }
}
