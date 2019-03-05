<?php
namespace app\admin\model;
use think\Model;

class AuthRule extends Model
{
    public function authRuleTree(){
        $cateres = $this->order("sort desc")->select();
        return $this->sort($cateres);
    }

    public function sort($data,$pid=0){
        static $arr = array();
        foreach ($data as $k=>$v){
            if($v['pid']==$pid){
                $v['dataid'] = $this->getparentid($v['id']);
                $arr[] = $v;
                $this->sort($data,$v['id']);
            }
        }
        return $arr ;
    }

    public function getchildrenid($id){
        $data = $this->select();
        return $this->_getchildrenid($data,$id);

    }

    public function _getchildrenid($data,$id){
        static $arr = array();
        foreach ($data as $k=>$v){
            if($v['pid']==$id){
                $arr[] = $v['id'];
                $this->_getchildrenid($data,$v['id']);
            }
        }
        return $arr;

    }

    public function getparentid($authRuleId){
        $AuthRuleRes=$this->select();
        return $this->_getparentid($AuthRuleRes,$authRuleId,True);
    }

    public function _getparentid($AuthRuleRes,$authRuleId,$clear=False){
        static $arr=array();
        if($clear){
            $arr=array();
        }
        foreach ($AuthRuleRes as $k => $v) {
            if($v['id'] == $authRuleId){
                $arr[]=$v['id'];
                $this->_getparentid($AuthRuleRes,$v['pid'],False);
            }
        }
        asort($arr);
        $arrStr=implode('-', $arr);
        return $arrStr;
    }

}