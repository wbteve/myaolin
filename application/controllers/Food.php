<?php
/**
 * Created by PhpStorm.
 * User: LiuFeng
 * Date: 2017/8/30
 * Time: 10:43
 * 吃在瑶琳
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Food extends MainController
{
    public $mainTemplatePath = 'main/food/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('foodModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index($currentPageNumber = null)
    {
        $content['pageTitle'] = '吃在瑶琳 - 瑶琳国家森林公园';
        $content['currentPageNumber'] = $currentPageNumber ? $currentPageNumber : 1;
        $content['food'] = $this->foodModel->getFoodM($currentPageNumber, null, 8);
        $data = $this->foodModel->getFoodM(3,'',4);
        if($data['food']){
            $content['num'] = 1;
        }else{
            $content['num'] = 2;
        }
//        var_dump($content);
//        die;
        $this->load->view($this->mainTemplatePath . $this->router->fetch_method(), $content);
        $this->load->view('main/template/footer');
    }

    public function detail($id)
    {
        $content['item'] = $this->foodModel->getFoodById($id);

        $this->content['pageTitle'] = $content['item']['title'];

        $this->renderView($this->mainTemplatePath . $this->router->fetch_method(), $content);
    }
    
    //吃在瑶琳加载更多
    public function ajaxFood()
    {
        $p = $this->input->get('p');
        $foods = $this->foodModel->getFoodM($p,'',4);
        $data = $this->foodModel->getFoodM(($p+1),'',4);
        if($data['food']){
            $num = 1;
        }else{
            $num = 2;
        }
        $html = '';
        foreach ($foods['food'] as $k => $v){
            $html .= '<li style="margin-right:5px;width:48%;"><img src="'.$v['coverImage'].'" style="height:115px;"/><p class="mli_p"><a href="#">'.$v['title'].'</a></p><p class="mli_pa">'.$v['description'].'</p></li>';
        }
        $rst['html'] = $html;
        $rst['num'] = $num;
        echo json_encode($rst);
    }
}
