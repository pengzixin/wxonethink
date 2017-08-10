<?php
namespace Admin\Controller;
class RepairController extends AdminController{
    //报修首页
    public function index(){
        /* 获取频道列表 */
        $list = M('Repair')->order('id asc')->select();
        $this->assign('list', $list);
        $this->meta_title = '报修管理';
        $this->display('index');
    }
    //添加
    public function add(){
        if(IS_POST){
            $Repair = D('Repair');
            $data = $Repair->create();
            $string='abcdefg';
            $string=str_shuffle($string);
            $data['numbers']=date('Ymd').'-'.substr($string,0,4);
            if($data){
                $id = $Repair->add($data);
                if($id){
                    $this->success('新增成功', U('index'));
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
    //修改v
    public function edit($id=0){
        if(IS_POST){
            $Repair = D('Repair');
            $data = $Repair->create();
            if($data){
                if($Repair->save()){
                    //记录行为
                    action_log('update_repair', 'repair', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Repair->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Repair')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->display();
        }
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
            if(M('Repair')->where($map)->delete()){
                //记录行为
                action_log('update_repair', 'repair', $id, UID);
                $this->success('删除成功');
            } else {
                $this->error('删除失败！');
            }
        }

}