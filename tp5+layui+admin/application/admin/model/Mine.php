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
use think\Model;

/**模型名称对应数据库名字
 * Class XXXX
 * @package app\admin\model
 */
class Mine extends Model
{
    /*
     * 过滤数据库不存在的字段
     */
    protected $field = true;


}