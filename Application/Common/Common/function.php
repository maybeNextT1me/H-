<?php
// 下载图片
function download_img($file, $file_name='default'){
    $file = "./Uploads/Cust_acct/".$file;
    header("Content-type: octet/stream");
    header("Content-disposition:attachment;filename=".$file_name.";");
    header("Content-Length:".filesize($file));
    readfile($file);
    exit;
}
 
// 调试
function dd($data) {
    echo "<pre>";
    dump($data);
    echo '</pre>';exit;
}

function p($data){
    if(!$data){
        dump($data);
    };
    if(is_array($data)){
        $c = count($data);
        echo "统计元素:　　" .$c;
        echo '<hr/>';
    }
    echo "<pre>";
        print_r($data);
    echo '</pre>';exit;
}

// 导出EXCEL
function exportexcel($data=array(),$title=array(),$filename='report'){
    error_reporting(E_ALL);
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            $title[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
            }
            $data[$key]=implode("\t", $data[$key]);

        }
        echo implode("\n",$data);
    }
    exit;
}

// 2维数组排序
function array_sort($array,$row,$type='asc'){
    $array_temp = array();
    $i = 1;
    foreach($array as $v){
        $array_temp[$v[$row].$i] = $v;
        $i++;
    }
    if($type == 'asc'){
        ksort($array_temp);
    }elseif($type='desc'){
        krsort($array_temp);
    }else{
       
    }
  return $array_temp;
}

function xmlToArray($simpleXmlElement){
	$simpleXmlElement=(array)$simpleXmlElement;
	foreach($simpleXmlElement as $k=>$v){
		if($v instanceof SimpleXMLElement ||is_array($v)){
			$simpleXmlElement[$k]=xmlToArray($v);
		}
	}
	return $simpleXmlElement;
}

//返回Json格式
function returnJson($data = '', $retcode = 200, $msg = ''){
	header('Content-Type: application/json');
	$tmp_arr = array();
	$tmp_arr['data'] = $data;
	$tmp_arr['retcode'] = $retcode;
	$tmp_arr['msg'] = $msg;
	echo json_encode($tmp_arr);
  die;
}

function returnInfo($data = '', $retcode = 200, $msg = ''){
	$tmp_arr = array();
	$tmp_arr['data'] = $data;
	$tmp_arr['retcode'] = $retcode;
	$tmp_arr['msg'] = $msg;
	return $tmp_arr;
}

// 调试
function _dump($vars, $label = '', $return = false) {
    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    } else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if ($return) { return $content; }
    echo $content;
    return null;
}

// 中文截取
function subtext($text, $length) {
    if(mb_strlen($text, 'utf8') > $length)
    return mb_substr($text, 0, $length, 'utf8').'...';
    return $text;
}

// 扩展类存取redis值
// function redis_set($key, $value){
//     \Predis\Autoloader::register();
//     $server  =  array (
//        'host'      =>  '127.0.0.1' ,
//        'port'      =>  6379 ,
//     ) ;
//     $a = new \Predis\Client($server);
//     return $a->set($key, $value);
// }

// function redis_setex($key, $time, $value){
//     \Predis\Autoloader::register();
//     $server  =  array (
//       'host'      =>  '127.0.0.1' ,
//       'port'      =>  6379 ,
//     ) ;
//     $a = new \Predis\Client($server);
//     return $a->setex($key, $time, $value);
// }

function redis_set($key, $value){
     \Predis\Autoloader::register();
    $server  =  array (
       'host'      =>  '127.0.0.1' ,
       'port'      =>  6379 ,
    ) ;

    $a = new \Predis\Client($server);
    $a->auth("chen");
    return $a->set($key, $value);
}    

function redis_setex($key, $time, $value){
    \Predis\Autoloader::register();
    $server  =  array (
      'host'      =>  '127.0.0.1' ,
      'port'      =>  6379 ,
    ) ;
    $a = new \Predis\Client($server);
    $a->auth("chen");
    return $a->setex($key, $time, $value);
}

function redis_get($key){
    \Predis\Autoloader::register();
    $server  =  array (
      'host'      =>  '127.0.0.1' ,
      'port'      =>  6379 ,
    ) ;
    $a = new \Predis\Client($server);
    $a->auth("chen");
    return $a->get("{$key}");
}
 
// 分页
function pageAction($table_name, $map=null, $order=null){
  $model          = D($table_name);
  $count          = $model->where($map)->count();
  $page           = new \Think\Page($count, PAGE);
  $list['list']   = $model->where($map)->order($order)->limit($page->firstRow.','.$page->listRows)->select();
  $list['pageButton'] = $page->show();
  return  $list;
}

// 通过电话号获取用户主键 并验证token
function getCustId(){
    $phone = I('post.phone_code');
    if (empty( I('phone_code') ) ){
        returnJson(0, 100001, '缺少客户手机号');
    }else{
        check_token(I('token'));
        $cust_id = D('cust_info')->getFieldByPhoneCode(I('phone_code'),'cust_id');
        if(!$cust_id){
          returnJson($_POST['phone_code'], 100006, '手机号错误');
        }
    }
    return $cust_id;
}

// postCURL请求
function postUrl($url,$data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_URL,$url);
    //为了支持cookie
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    //返回结果
    //拒绝验证ca证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close ($ch);
    return $result;
}

/**
 * 检查post参数
 * [check_param description]
 * @param  [type] $arr [description]
 * @return [type]      [description]
 */
function check_param($arr){
    foreach($arr as $v){
      if(!isset($_POST[$v]) || empty($_POST[$v])){
          return '必填参数不能为空';
      }
    } 
    return false; 
}

// 获取当前url地址
function curGetURL() {
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on") 
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } 
    else 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

// 检查数组数据, 将空值用 字符串 '暂无' 填充
function format_array(&$array){
    foreach($array as $k=>&$v){
        if(is_array($v)) format_array($v);
        if(is_null($v)) $v = '暂无';
    }   
    
    return $array ;
}

/**
 * 检查请求必传参数
 * @param  [type] $arr  超全局数组get post下标数组
 * @param  string $type get , post   
 * @return [type]       参数符合返回false ， 参数错误返回错误信息
 */

function check_request_param($arr, $type='get'){
    if($type == 'get'){
        foreach($arr as $v){
            if( is_null(I('get.'.$v)) ) return '请求错误,缺失参数'.$v ;
        }
    }
    else{
        foreach($arr as $v){
            if( is_null(I('post.'.$v)) ) return '请求错误,缺失参数'.$v ;
        }   
    }
    return false;
}    

// 单向加密 15位密码
function md5_plus($str){
    $byte = "QnMlGbCnM";
    $str .= $byte;
    return substr(md5(md5($str)), -15);
}

// 去除标签且去除空白..
function c_strip_tags($str){
    $subject = strip_tags($str);//去除html标签
    $pattern = '/\s/';//去除空白
    $content = preg_replace($pattern, '', $subject);            
    // $seodata['articledescription'] = mb_substr($content, 0, 80);//截取80个汉字
    return $content;
}

// 发送短信
function sendSms($tel, $code){
    $a = new \Think\ChuanglanSmsApi();
    $msg = "【明规则】".$code."（明规则验证码，请完成操作），有效期为5分钟，如非本人操作，请忽略。";
    return $a->sendSMS($tel,$msg);
}

// 写入日志
function write_log($sql='~~~empty', $type='success'){
    $data = [
        'create_date' => date('Y-m-d H:i:s', time()),
        'page'        => CONTROLLER_NAME.'/'.ACTION_NAME,
        'session_id'  => $_SESSION['id'],
        'sql'         => $sql, 
        'type'        => $type,  
    ];
    return D('log')->add($data);
}