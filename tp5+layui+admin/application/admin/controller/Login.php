<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * XXXX管控制器
 * 功能【1.XXXX查询输出(index)。2.增加XXXX（add）。3.修改XXXX(edit)。4.删除XXXX(del)】
 * Class Menu
 * @package app\admin\controller
 */
class Login extends Common
{
    /**调用XXXX模型model
     * @var string
     */
    private $model = 'XXXX';
    /**查询所有数据
     * @return string
     */
    public function index()
    {
        return view();
    }

    public function login()
    {
        $table_model = new \app\admin\model\Admin() ;
        $data = input('post.');
        $listV = $table_model->loginValidate($data);//验证不能为空的数据
        return $listV ? $listV:$table_model->login($data);
    }

}
