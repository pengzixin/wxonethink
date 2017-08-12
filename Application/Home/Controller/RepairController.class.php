<?php
namespace Home\Controller;
use Think\Page;

class RepairController extends HomeController{
    //报修首页
    public function index(){
        $model=M('Repair');
        $page=I('get.p',0);
        $PageSize=6;//自定义显示条数
        $list= $model->order('id asc')->limit($page*$PageSize,$PageSize)->select();
        if($page>0){
            $result=[];
//            var_dump($list);exit;
            if($list!=null){
                foreach($list as &$v){
                    $v['status']=get_status($v['status']);
                    $v['create_time']=date('Y-m-d H:i',$v['create_time']);
                }
                //var_dump($list);exit;
                $result=[
                    'status'=>1,
                    'msg'=>'获取数据成功',
                    'page'=>$list
                ];
            }else{
                $result=[
                    'status'=>0,
                    'msg'=>'没有更多数据',
                    'page'=>[]
                ];
            }
            //var_dump($result);exit;
            echo json_encode($result);
        }else{
            //var_dump($list);exit;
            $this->assign('list', $list);
            $this->meta_title = '报修管理';
            $this->display('index');
        }
    }
    //添加
    public function add(){
        if(IS_POST){
            $Repair = new \Home\Model\RepairModel();
            $data = $Repair->create();
            if($data){
                $string='abcdefg';
                $string=str_shuffle($string);
                $data['numbers']=date('Ymd').'-'.substr($string,0,4);
                $id = $Repair->add($data);
                if($id){
                    $this->redirect('index','新增成功');
                    //记录行为
                    action_log('update_repair', 'repair', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Repair->getError());
            }
        }
            $this->assign('info',null);
            $this->display('edit');
        }
    /*
     * 删除
     */
        public function del(){
            $id = array_unique((array)I('id',0));

            if ( empty($id) ) {
                $this->error('请选择要操作的数据!');
            }

            $map = array('id' => array('in', $id) );
            $data['status']=3;
            if(M('Repair')->where($map)->save($data)){
                //记录行为
                action_log('update_repair', 'repair', $id, UID);
                $this->success('取消成功');
            } else {
                $this->error('取消失败！');
            }
        }

}