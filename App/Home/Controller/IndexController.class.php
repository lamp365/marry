<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
        $condition = 'blong=1';
        if(!empty($_POST['name'])){
            $condition .= " and name='{$_POST['name']}'";
        }
        if(!empty($_GET['type']) && $_GET['type'] != -1){
            $condition .= " and type={$_GET['type']}";
        }
        if(!empty($_GET['cancomming']) && $_GET['cancomming'] != -1){
            $condition .= " and cancomming={$_GET['cancomming']}";
        }

        $user = M('namelist');
        $info = $user->where($condition)->select();

        $tongxue_type = C('tongxue_type');
        $can_comming  = C('can_comming');
        $this->assign('info',$info);
        $this->assign('tongxue_type',$tongxue_type);
        $this->assign('can_comming',$can_comming);
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
        $type        = $_POST['type'];
        $mobile      = $_POST['mobile'];
        $data       = array(
            'name'        =>$name,
            'cancomming'  =>$cancomming,
            'mobile'      =>$mobile,
            'type'        =>$type,
            'blong'       =>1,
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
        $cancomming  = $_POST['cancomming'];
        $type        = $_POST['type'];
        $data        = array(
            'name'        =>$name,
            'cancomming'  =>$cancomming,
            'mobile'      =>$mobile,
            'type'        =>$type,
            'modifytime'  =>time()
        );
        $user       = M('namelist');
        $user->where("id={$id}")->save($data);
        $this->showSuccess(200,'修改成功');
    }
    public function delUser(){
        $id          = $_GET['id'];
        $user        = M('namelist');
        $user->where("id={$id}")->delete();
        $this->showSuccess(200,'删除成功');
    }

    function getUser(){
        $id   = $_GET['id'];
        $user = M('namelist');
        $info = $user->find($id);

        if(!empty($info)) {
            $tongxue_type = C('tongxue_type');
            $can_comming  = C('can_comming');
            $type_option = $comming_option = '';
            foreach($tongxue_type as $key => $val){
                if($key == $info['type']){
                    $sel = "selected";
                }else{
                    $sel ='';
                }
                $type_option .= "<option value='{$key}' {$sel}>{$val}</option>";
            }
            foreach($can_comming as $key => $val){
                if($key == $info['cancomming']){
                    $sel = "selected";
                }else{
                    $sel ='';
                }
                $comming_option .= "<option value='{$key}' {$sel}>{$val}</option>";
            }

            $html = "
                 <div class='form-group'>
                    <input type='text' class='form-control' name='name' id='edit_name_put' placeholder='请输入名字' value='{$info['name']}'>
                 </div>
                 <div class='form-group'>
                    <input type='text' class='form-control' name='mobile' id='edit_mobile_put' placeholder='请输入电话' value='{$info['mobile']}'>
                 </div>
                 <div class='row' style='margin-bottom: 15px;overflow: hidden'>
                        <div class='col-xs-6'>
                            <select name='type' id='edit_type_put' class='form-control'>
                               {$type_option}
                            </select>
                        </div>
                        <div class='col-xs-6'>
                            <select name='cancomming' id='edit_comming_put' class='form-control'>
                               {$comming_option}
                            </select>
                        </div>
                 </div>
            ";
        }else{
            $html = '查无数据，异常！';
        }

        $this->showSuccess(200,$html);
    }

    public function showSuccess($code,$msg){
        die(json_encode(array(
            'code'=>$code,
            'msg'=>$msg,
        )));
    }
}