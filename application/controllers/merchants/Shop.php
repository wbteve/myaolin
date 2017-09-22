<?php
/**
 * Created by PhpStorm.
 * User: LiuFeng
 * Date: 2017/9/20
 * Time: 15:44
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__FILE__) . '/../../util/WeChat.php';
require_once dirname(__FILE__) . '/../../util/WeChatJsApiPay.php';
require_once dirname(__FILE__) . '/../../util/XmlTool.php';

class Shop extends CI_Controller
{
    public $mainTemplatePath = 'main/merchants/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('memberModel');
        $this->load->model('productModel');
        $this->load->model('orderModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function test()
    {
        echo date('YmdHis');
        exit;
        $products = $this->productModel->getProducts()['products'];
        var_dump($products);
        exit;
        $string = '{
            "appid": "wx7c0adb91597ff4e8",
    "bank_type": "CCB_DEBIT",
    "cash_fee": "1",
    "device_info": "WEB",
    "fee_type": "CNY",
    "is_subscribe": "Y",
    "mch_id": "1486544382",
    "nonce_str": "Eew2RFeHBWUk5mhchga3myYlTOdMeZNV",
    "openid": "o5p6C1a5mmG6VZRJIzA-dbuUfsME",
    "out_trade_no": "20170830140003",
    "result_code": "SUCCESS",
    "return_code": "SUCCESS",
    "sign": "63C9BEBF465DADA0290F340B23624700",
    "time_end": "20170921091304",
    "total_fee": "1",
    "trade_type": "JSAPI",
    "transaction_id": "4200000014201709213324467577"
}';
        $a = json_decode($string, true);
        echo $a['appid'];
        exit;
        $data['appid'] = 'wx7c0adb91597ff4e8';
        $data['bank_type'] = 'CCB_DEBIT';
        $data['cash_fee'] = '1';
        $data['device_info'] = 'WEB';
        $data['fee_type'] = 'CNY';
        $data['is_subscribe'] = 'Y';
        $data['mch_id'] = '1486544382';
        $data['result_code'] = 'SUCCESS';
        $data['return_code'] = 'SUCCESS';
        $data['nonce_str'] = 'Eew2RFeHBWUk5mhchga3myYlTOdMeZNV';
        $data['openid'] = 'o5p6C1a5mmG6VZRJIzA-dbuUfsME';
        $data['out_trade_no'] = '20170830140003';
        $data['time_end'] = '20170921091304';
        $data['total_fee'] = '1';
        $data['trade_type'] = 'JSAPI';
        $data['transaction_id'] = '4200000014201709213324467577';

        var_dump(\util\WeChatJsApiPay::sign($data));
    }

    public function index($merchantId)
    {
        $url = \util\WeChat::authorize($merchantId);
        header("Location: $url");
    }

    public function products($merchantId)
    {
        $code = $this->input->get('code');
        $memberInfo = json_decode(\util\WeChat::getWeChatMemberInfo($code), true);

        $_SESSION['openid'] = $content['openid'] = $memberInfo['openid'];
        $content['nickname'] = $memberInfo['nickname'];
        $_SESSION['merchant']['id'] = $content['merchant']['id'] = $merchantId;

        if (!$this->memberModel->isExistMember(MemberModel::SOURCE_TYPE_WECHAT, $memberInfo['openid'])) {
            $this->memberModel->saveMember(MemberModel::SOURCE_TYPE_WECHAT, $memberInfo['openid'], $memberInfo['nickname']);
        }

        $content['products'] = $this->productModel->getProducts()['products'];

        $this->load->view($this->mainTemplatePath .$this->router->fetch_method(), $content);
    }

    public function loadAddOrder()
    {
        $content['productId'] = '';
        $content['productFee'] = '';

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $content['productId'] = $this->input->post('productId');
            $content['productFee'] = $this->input->post('productFee');
        }

        $orderId = 'M' . $_SESSION['merchant']['id'] .$_SESSION['member']['uid'] . date('YmdHis');

        $_SESSION['orderId'] = $orderId;
        $_SESSION['productId'] = $content['productId'];
        $_SESSION['productFee'] = $content['productFee'];
//
//        $this->orderModel->saveOrder(null, $orderId, $_SESSION['member']['uid'], $_SESSION['merchant']['id'], $content['productFee']);
//
//        return true;
        echo $_SESSION['member']['uid'];
    }

    public function initJSAPI()
    {
        $content = [];

        $content['productId'] = '';
        $content['productFee'] = '';

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $content['productId'] = $this->input->post('productId');
            $content['productFee'] = $this->input->post('productFee');
        }

//        $orderId = 'M' . $_SESSION['merchant']['id'] .$_SESSION['member']['uid'] . date('YmdHis');
        $orderId = 'M' . $_SESSION['merchant']['id'] . date('YmdHis');

        //wx20170920170701cf99b1bfca0068409885
//        $content['jsApiParameters'] = json_encode(\util\WeChatJsApiPay::getJsApiParameters('o5p6C1a5mmG6VZRJIzA-dbuUfsME', 'abc', 20170830140010, 1, base_url() . 'merchants/shop/notify', 6600112));
        $content['jsApiParameters'] = json_encode(\util\WeChatJsApiPay::getJsApiParameters($_SESSION['member']['uid'], '产品' . $content['productId'], $orderId, $content['productFee'], base_url() . 'merchants/shop/notify', $content['productId']));
        $this->load->view($this->mainTemplatePath .$this->router->fetch_method(), $content);
    }

    public function notify()
    {
        $response = json_decode(json_encode(\util\XmlTool::xml2Array($GLOBALS['HTTP_RAW_POST_DATA'])), true); //php://input 也可以处理原始post

        if ($response && $response['result_code'] == 'SUCCESS' && $response['return_code'] == 'SUCCESS') {
            $data['appid'] = $response['appid'];
            $data['bank_type'] = $response['bank_type'];
            $data['cash_fee'] = $response['cash_fee'];
            $data['device_info'] = $response['device_info'];
            $data['fee_type'] = $response['fee_type'];
            $data['is_subscribe'] = $response['is_subscribe'];
            $data['mch_id'] = $response['mch_id'];
            $data['result_code'] = $response['result_code'];
            $data['return_code'] = $response['return_code'];
            $data['nonce_str'] = $response['nonce_str'];
            $data['openid'] = $response['openid'];
            $data['out_trade_no'] = $response['out_trade_no'];
            $data['time_end'] = $response['time_end'];
            $data['total_fee'] = $response['total_fee'];
            $data['trade_type'] = $response['trade_type'];
            $data['transaction_id'] = $response['transaction_id'];

            if (\util\WeChatJsApiPay::sign($data) == $response['sign']) {

            }

            echo 'SUCCESS';
        } else {
            echo 'FAIL';
        }
//        {
//            "appid": "wx7c0adb91597ff4e8",
//    "bank_type": "CCB_DEBIT",
//    "cash_fee": "1",
//    "device_info": "WEB",
//    "fee_type": "CNY",
//    "is_subscribe": "Y",
//    "mch_id": "1486544382",
//    "nonce_str": "Eew2RFeHBWUk5mhchga3myYlTOdMeZNV",
//    "openid": "o5p6C1a5mmG6VZRJIzA-dbuUfsME",
//    "out_trade_no": "20170830140003",
//    "result_code": "SUCCESS",
//    "return_code": "SUCCESS",
//    "sign": "63C9BEBF465DADA0290F340B23624700",
//    "time_end": "20170921091304",
//    "total_fee": "1",
//    "trade_type": "JSAPI",
//    "transaction_id": "4200000014201709213324467577"
//}
    }
}