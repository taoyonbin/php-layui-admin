<?php
/**
 * Created by PhpStorm.
 * User: YOULIN
 * Date: 2019-08-22
 * Time: 14:40
 */
namespace app\admin\model;

/**
 * 继承model
 */
use think\Cache;
use think\Model;
use think\Validate;

/**领域管理
 * Class ArticleType
 * @package app\admin\model
 */
class DoFile extends Model
{
    /*
        * 过滤数据库不存在的字段
*/
    protected $field = true;
    protected $add_rule = [
        'title'      => 'require',
        'path'      => 'require',
        'do_id'      => 'require',
        'type'      => 'require',
        'size'      => 'require',
        'is_do'      => 'require',
    ];
    /**内容
     * @var array
     */
    protected $add_message = [
        'title.require'          => '文件名称不能为空' ,

        'path.require'       => '路径地址不能为空' ,
        'do_id.require'        => '文件所属不存在' ,
        'type.require'    => '图片或文件类型未指定' ,
        'size.require'    => '文件大小错误' ,
        'is_do.require'             => '文件所属类型未指定' ,

    ];

    protected $dele_rule = [
        'id'      => 'require',
        'user_id'      => 'require',
    ];
    /**内容
     * @var array
     */
    protected $dele_message = [
        'id.require' => '参数错误',
        'user_id.require' => '未知所属',
    ];
    /**注册数据验证
     * @param $data
     * @return string
     */
    public function addValidate($data){
        $validate = new Validate($this->add_rule,$this->add_message);
        $result   =  $validate->batch()->check($data);

        if(!$result){
            return error_action('验证失败',$validate->getError());
        }

    }
    /**修改数据验证
     * @param $data
     * @return string
     */
    public function editValidate($data){
        $validate = new Validate($this->edit_rule,$this->edit_message);
        $result   = $validate->check($data);
        if(!$result){
            return error_action('验证失败',$validate->getError());
        }
    }


    /**添加数据
     * @param $data
     * @return string
     */
    public function addall($data){
        $smodel = new DoFile();
        if($smodel->saveAll($data)){
            return true ;
        }else{
            return false;
        }
    }

    /**修改数据
     * @param $data
     * @return string
     */
    public function editall($id,$data){
        $smodel = new DoFile();
        $smodel->where(['do_id'=>$id])->delete();
        if($smodel->saveAll($data)){
            return true ;
        }else{
            return false;
        }
    }
}