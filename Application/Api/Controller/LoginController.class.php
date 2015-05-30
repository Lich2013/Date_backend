<?php
namespace Api\Controller;
use Think\Controller;
class LoginController extends Controller {
    private $url = 'http://hongyan.cqupt.edu.cn/RedCenter/Api/Handle/login';
    //登录
    public function login() {
        $input = I('post.');
        if(!isset($input['username']) || !isset($input['password']) || $input['username'] == null || $input['password'] == null){
            $data = [
                'status' => 403,
                'info' => '参数错误'
            ];
            $this->ajaxReturn($data);
        }
        if(!$this->verify($input['username'], $input['password'])) {
            $data = [
                'status' => 403,
                'info' => '身份认证错误还想约炮?!'
            ];
            $this->ajaxReturn($data);
        }
        else{
            $data = [
                    'status' => 200,
                    'info' => '登录成功, 可以开始约炮→_→'
            ];
            $this->ajaxReturn($data);
        }

    }

    //验证
    private function verify($username, $password) {
        $data = [
            'user' => $username,
            'password' => $password
        ];
        $result = $this->curl($data);
        if($result->status == 200){

            return true;
        }
        else{
            return false;
        }
    }

    //curl
    private function curl($data = []){
            // 初始化一个curl对象
            $ch = curl_init();
            curl_setopt ( $ch, CURLOPT_URL, $this->url );
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            curl_setopt ( $ch, CURLOPT_HEADER, 0 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
            // 运行curl，获取网页。
            $contents = json_decode(curl_exec($ch));
            // 关闭请求
            curl_close($ch);
            return $contents;
    }
}