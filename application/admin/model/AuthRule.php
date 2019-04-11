<?php
namespace app\admin\model;
use think\Model;

class AuthRule extends Model
{
    public function authRuleTree()
    {
        $cateres = $this->order("sort desc")->select();
        return $this->sort($cateres);
    }

    public function sort($data,$pid=0)
    {
        static $arr = array();
        foreach ($data as $k=>$v){
            if($v['pid']==$pid){
                $v['dataid'] = $this->getparentid($v['id']);
                $arr[] = $v;
                $this->sort($data,$v['id']);    //递归
            }
        }
        return $arr ;
    }

    public function getchildrenid($id)  //得到所有子id
    {
        $data = $this->select();
        return $this->_getchildrenid($data,$id);
    }

    public function _getchildrenid($data,$id)
    {
        static $arr = array();
        foreach ($data as $k=>$v){
            if($v['pid']==$id){
                $arr[] = $v['id'];
                $this->_getchildrenid($data,$v['id']);  //递归
            }
        }
        return $arr;
    }

    public function getparentid($authRuleId)    //得到所有父级id
    {
        $AuthRuleRes=$this->select();
        return $this->_getparentid($AuthRuleRes,$authRuleId,True);
    }

    public function _getparentid($AuthRuleRes,$authRuleId,$clear=False)
    {
        static $arr=array();
        if($clear){     //防止共用一个array
            $arr=array();
        }
        foreach ($AuthRuleRes as $k => $v) {
            if($v['id'] == $authRuleId){
                $arr[]=$v['id'];
                $this->_getparentid($AuthRuleRes,$v['pid'],False);
            }
        }
        asort($arr);
        $arrStr=implode('-', $arr); //拼接
        return $arrStr;
    }

}