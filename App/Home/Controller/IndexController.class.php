<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
        $condition = '';
        if(!empty($_POST['type'])){
            $condition = "type={$_POST['type']}";
        }
        if(!empty($_POST['cancomming'])){
            $condition = "cancomming={$_POST['cancomming']}";
        }
        $user = M('namelist');
        if(!empty($condition)){
            $info = $user->where($condition)->select();
        }else{
            $info = $user->select();
        }

        $this->display('info',$info);
        $this->display();
    }

    public function qiandao()
    {
        $start_time = strtotime("2017-1-14 12:00:00");
        if(time()<$start_time){
            $begin  = false;
        }else{
            $begin = true;
            $condition = '';
            if(!empty($_POST['type'])){
                $condition = "type={$_POST['type']}";
            }
            if(!empty($_POST['iscomming'])){
                $condition = "iscomming={$_POST['iscomming']}";
            }
            if(!empty($_POST['name'])){
                $condition = "name='{$_POST['name']}'";
            }
            $user = M('namelist');
            if(!empty($condition)){
                $info = $user->where($condition)->select();
            }else{
                $info = $user->select();
            }
            $this->display('info',$info);
        }
        $this->assign('begin',$begin);
        $this->assign('start_time',$start_time);
        $this->display();
    }

    public function iscomming(){
        $id         = $_POST['id'];
        $cancomming = $_POST['iscomming'];
        $user       = M('namelist');
        $user->where("id=$id")->save(array('iscomming'=>$cancomming));
        $this->showSuccess(200,'操作成功');
    }

    public function cancomming(){
        $id         = $_POST['id'];
        $cancomming = $_POST['cancomming'];
        $user       = M('namelist');
        $user->where("id=$id")->save(array('cancomming'=>$cancomming));
        $this->showSuccess(200,'操作成功');
    }

    public function addUser(){
        $name        = $_POST['name'];
        $cancomming  = $_POST['cancomming'];
        $mobile      = $_POST['mobile'];
        $data       = array(
            'name'        =>$name,
            'cancomming'  =>$cancomming,
            'mobile'      =>$mobile,
            'createtime'  =>time(),
            'modifytime'  =>time()
        );
        $user       = M('namelist');
        $res = $user->add($data);
        if($res)
            $this->showSuccess(200,'添加成功');
        else
            $this->showSuccess(200,'添加失败');
    }
    public function editUser(){
        $id          = $_POST['id'];
        $name        = $_POST['name'];
        $mobile      = $_POST['mobile'];
        $data       = array(
            'name'        =>$name,
            'mobile'      =>$mobile
        );
        $user       = M('namelist');
        $user->where("id={$id}")->save($data);
        $this->showSuccess(200,'修改成功');
    }

    public function showSuccess($code,$msg){
        die(json_encode(array(
            'code'=>$code,
            'msg'=>$msg,
        )));
    }
}