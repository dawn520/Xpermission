<?php
/**
 * Created by PhpStorm.
 * User: zhouchenxi
 * Date: 2017/2/17
 * Time: 17:02
 */


namespace App\Http\Controllers;

use App\Http\Requests\AddPermissionRequest;
use App\Http\Requests\AddRoleRequest;
use App\Http\Requests\AddUserRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /**
     * 添加一个用户
     *
     * @param AddUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUser(AddUserRequest $request)
    {
        if($user = User::where('username',$request->userFillData()['username'])->first()){
            $error = [
                'username'=>['此用户名已经存在']
            ];
            return response()->json(Helper::createResponseData('31102',$error));
        }
        if(User::where('email', $request->userFillData()['email'])->first()){
            $error = [
                'email'=>['此email已经存在']
            ];
            return response()->json(Helper::createResponseData('31103',$error));
        }
        User::create($request->userFillData());
        return response()->json(Helper::createResponseData('20000','创建成功'));


    }

    /**
     * 显示用户列表
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUserList(Request $request)
    {
        $param = $request->all();
        if (empty($param)) {
            return response()->json(['error' => '参数错误！']);
        }
        $page = $param['start'] / $param['length'] + 1;
        switch ($param['order'][0]['column']) {
            case 0:
                $orderName = 'id';
                break;
            case 1:
                $orderName = 'name';
                break;
            case 4:
                $orderName = 'created_at';
                break;
            case 5:
                $orderName = 'updated_at';
                break;
        }
        $user = User::where('username', 'like', '%' . $param['search']['value'] . '%')
            ->orderBy($orderName, $param['order'][0]['dir'])
            ->paginate($param['length'], $columns = ['*'], $pageName = 'page', $page);
        $returnData = [
            'draw' => intval($param['draw']),
            'recordsFiltered' => $user->total(),
            'recordsTotal' => $user->total(),
            'data' => $user->items()
        ];
        // return response()->json(Helper::createResponseData('21102','读取成功',$returnData));
        return response()->json($returnData);
    }

    /**
     * 添加一个权限
     *
     * @param AddPermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPermission(AddPermissionRequest $request){
        if(Permission::where('name',$request->name)->first()){
            $error = [
                'name'=>['此权限名已经存在']
            ];
            return response()->json(Helper::createResponseData('31202',$error));
        }
        $permission = new Permission();
        $permission->name         = $request->name;
        $permission->display_name = $request->displayName;
        $permission->description  = $request->description == null ? '' : $request->description;
        $permission->save();
        return response()->json(Helper::createResponseData('20000','创建成功'));
    }

    /**
     * 显示权限列表
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPermissionList(Request $request)
    {
        $param = $request->all();
        if (empty($param)) {
            return response()->json(['error' => '参数错误！']);
        }
        $page = $param['start'] / $param['length'] + 1;
        switch ($param['order'][0]['column']) {
            case 0:
                $orderName = 'id';
                break;
            case 1:
                $orderName = 'name';
                break;
            case 4:
                $orderName = 'created_at';
                break;
            case 5:
                $orderName = 'updated_at';
                break;
        }
        $permission = Permission::where('name', 'like', '%' . $param['search']['value'] . '%')
            ->orderBy($orderName, $param['order'][0]['dir'])
            ->paginate($param['length'], $columns = ['*'], $pageName = 'page', $page);
        $returnData = [
            'draw' => intval($param['draw']),
            'recordsFiltered' => $permission->total(),
            'recordsTotal' => $permission->total(),
            'data' => $permission->items()
        ];
        // return response()->json(Helper::createResponseData('21102','读取成功',$returnData));
        return response()->json($returnData);
    }

    /**
     * 添加一个角色
     *
     * @param AddRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addRole(AddRoleRequest $request){
        if(Role::where('name',$request->name)->first()){
            $error = [
                'name'=>['此角色已经存在']
            ];
            return response()->json(Helper::createResponseData('31202',$error));
        }
        $role = new Role();
        $role->name         = $request->name;
        $role->display_name = $request->displayName;
        $role->description  = $request->description == null ? '' : $request->description;
        $role->save();
        return response()->json(Helper::createResponseData('20000','创建成功'));
    }

    public function showRoleList(Request $request)
    {
        $param = $request->all();
        if (empty($param)) {
            return response()->json(['error' => '参数错误！']);
        }
        $page = $param['start'] / $param['length'] + 1;
        switch ($param['order'][0]['column']) {
            case 0:
                $orderName = 'id';
                break;
            case 1:
                $orderName = 'name';
                break;
            case 4:
                $orderName = 'created_at';
                break;
            case 5:
                $orderName = 'updated_at';
                break;
        }
        $permission = Role::where('name', 'like', '%' . $param['search']['value'] . '%')
            ->orderBy($orderName, $param['order'][0]['dir'])
            ->paginate($param['length'], $columns = ['*'], $pageName = 'page', $page);
        $returnData = [
            'draw' => intval($param['draw']),
            'recordsFiltered' => $permission->total(),
            'recordsTotal' => $permission->total(),
            'data' => $permission->items()
        ];
        // return response()->json(Helper::createResponseData('21102','读取成功',$returnData));
        return response()->json($returnData);
    }
}