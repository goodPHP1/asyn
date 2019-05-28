<?php
$url = "http://localhost/other.php"; #url 地址必须 http://xxxxx
$t=30;
$data = array(
    'foo'=>'bar',
    'baz'=>'boom',
    'site'=>'www.manongjc.com',
    'name'=>'nowa magic');
/**fsockopen 抓取页面
 * @parem $url 网页地址 host 主机地址 
 * @parem $t 脚本请求时间 默认30s
 * @parem $post_data 如果单独传数据为 post 方式
 * @return 返回请求回的数据
 * */
function request_by_fsockopen($url,$t=30,$post_data=null,$debug=false){
    $url_array = parse_url($url);
    $hostname = $url_array['host'];
    $port = isset($url_array['port'])? $url_array['port'] : 80;
    @$requestPath = $url_array['path'] ."?". $url_array['query'];
    $fp = fsockopen($hostname, $port, $errno, $errstr, $t);
    if(!$fp){
        echo "$errstr ($errno)";
        return false;
    }
    $method = "GET";
    if(!empty($post_data)){
        $method = "POST";
    }
    stream_set_blocking($fp,true);//开启了手册上说的非阻塞模式
    stream_set_timeout($fp,1);//设置超时
    $header = "$method $requestPath HTTP/1.1".PHP_EOL;
    $header .= "Host: $hostname".PHP_EOL;
    if(!empty($post_data)){
        $_post = strval(NULL);
        foreach($post_data as $k => $v){
            $_post[]= $k."=".urlencode($v);//必须做url转码以防模拟post提交的数据中有&符而导致post参数键值对紊乱
        }
        $_post = implode('&', $_post);
        $header .= "Content-Type: application/x-www-form-urlencoded".PHP_EOL;//POST数据
        $header .= "Content-Length: ". strlen($_post) ."".PHP_EOL;//POST数据的长度
        $header.="Connection: Close".PHP_EOL.PHP_EOL;//长连接关闭
        $header .= $_post; //传递POST数据
    }
    else{
        $header.="Connection: Close".PHP_EOL.PHP_EOL;//长连接关闭
    }
    fwrite($fp, $header);
    // usleep(1000); //如果没有这延时，可能在nginx服务器上就无法执行成功，---没试过
    //-----------------调试代码区间-----------------
    //注如果开启下面的注释,异步将不生效可是方便调试
    // if($debug){
    //     $html = '';
    //     while (!feof($fp)) {
    //         $html.=fgets($fp);
    //     }
    //     echo $html;
    // }
    //-----------------调试代码区间-----------------
    fclose($fp);
    echo 1;
}
request_by_fsockopen($url,$t,$data,true);
?>