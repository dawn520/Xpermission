<?php
/**
 * Created by PhpStorm.
 * User: zhouchenxi
 * Date: 2017/2/17
 * Time: 17:02
 */


namespace App\Http\Controllers;

use App\Http\Requests\AddGroupRequest;
use App\Http\Requests\AddPermissionRequest;
use App\Http\Requests\AddRoleRequest;
use App\Http\Requests\AddUserRequest;
use App\Models\Group;
use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * 添加一个用户
     *
     * @param AddUserRequest $request
     * @return array
     */
    public function addUser(AddUserRequest $request)
    {
        if($user = User::where('username',$request->userFillData()['username'])->first()){
            $error = [
                'username'=>['此用户名已经存在！']
            ];
            return $this->error($error,401011);
        }
        if(User::where('email', $request->userFillData()['email'])->first()){
            $error = [
                'email'=>['此email已经存在！']
            ];
            return $this->error($error,401012);
        }
        User::create($request->userFillData());
        return $this->success("创建成功!");
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
        $page = $param['page'];
        $user = User::where('username', 'like', '%' . $param['query']. '%')
            ->orderBy(empty($param['orderBy'])?'id':$param['orderBy'])
            ->paginate($param['limit'], $columns = ['*'], $pageName = 'page', $page);
        $returnData = [
            'count' => $user->total(),
            'data' => $user->items()
        ];
        // return response()->json(Helper::createResponseData('21102','读取成功',$returnData));
        return response()->json($returnData);
    }
    public function showUserList2(Request $request)
    {
        $user = User::paginate(15);

        return response()->json($user);
    }

    /**
     * 添加一个权限组
     *
     * @param AddGroupRequest $request
     * @return array
     */
    public function addGroup(AddGroupRequest $request){
        if(Group::where('name',$request->name)->first()){
            $error = [
                'name'=>['此组名已经存在']
            ];
            return $this->error($error);
        }
        $Group = new Group();
        $Group->name         = $request->name;
        $Group->display_name = $request->displayName;
        $Group->description  = $request->description == null ? '' : $request->description;
        $Group->save();
        return $this->success("创建成功!");
    }

    /**
     * 显示权限列表
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showGroupList(Request $request)
    {
        $param = $request->all();
        if (empty($param)) {
            return response()->json(['error' => '参数错误！']);
        }
        $page = $param['page'];
        $permission = Group::where('name', 'like', '%' . $param['query']. '%')
            ->orderBy(empty($param['orderBy'])?'id':$param['orderBy'])
            ->paginate($param['limit'], $columns = ['*'], $pageName = 'page', $page);
        $returnData = [
            'count' => $permission->total(),
            'data' => $permission->items()
        ];
        // return response()->json(Helper::createResponseData('21102','读取成功',$returnData));
        return response()->json($returnData);
    }

    /**
     * 显示所有组
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllGroup(Request $request)
    {
        $permissions = Group::all();
        $returnData = [];
        foreach ($permissions as $item) {
            $returnData[] = [
                'id'   => $item['id'],
                'text' => $item['display_name']
            ];
        }
        return response()->json(Helper::createResponseData('200','读取成功',$returnData));
    }


    /**
     * 添加一个权限
     *
     * @param AddPermissionRequest $request
     * @return array
     */
    public function addPermission(AddPermissionRequest $request){
        DB::beginTransaction();
        if(Permission::where('name',$request->name)->first()){
            $error = [
                'name'=>['此权限名已经存在']
            ];
            return $this->error($error);
        }
        try{
            $permission = new Permission();
            $permission->name         = $request->name;
            $permission->display_name = $request->displayName;
            $permission->description  = $request->description == null ? '' : $request->description;
            $permission->save();
            $groupPermission = new GroupPermission();
            $groupPermission->group_id      = $request->groupId;
            $groupPermission->permission_id = $permission->id;
            $groupPermission->save();
            DB::commit();
            return $this->success("创建成功!");
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->error("创建失败!");
        }


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
        $page = $param['page'];
        $permission = Permission::where('name', 'like', '%' . $param['query']. '%')
            ->orderBy(empty($param['orderBy'])?'id':$param['orderBy'])
            ->paginate($param['limit'], $columns = ['*'], $pageName = 'page', $page);
        $returnData = [
            'count' => $permission->total(),
            'data' => $permission->items()
        ];
        // return response()->json(Helper::createResponseData('21102','读取成功',$returnData));
        return response()->json($returnData);
    }

    public function showaAllPermissions(Request $request)
    {
        $permissions = Permission::all();
         return response()->json(Helper::createResponseData('200','读取成功',$permissions));
    }

    /**
     * 添加一个角色
     *
     * @param AddRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addRole(AddRoleRequest $request){
        DB::beginTransaction();
        if(Role::where('name',$request->name)->first()){
            $error = [
                'name'=>['此角色已经存在']
            ];
            return $this->error($error);
        }
        try {
            $role = new Role();
            $role->name         = $request->name;
            $role->display_name = $request->displayName;
            $role->description  = $request->description == null ? '' : $request->description;
            $role->save();
            $role->perms()->sync($request->permissionsChecked);
            DB::commit();
            return $this->success("创建成功!");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error("创建失败!");
        }
    }

    public function showRoleList(Request $request)
    {
        $param = $request->all();
        if (empty($param)) {
            return response()->json(['error' => '参数错误！']);
        }
        $page = $param['page'];
        $permission = Role::where('name', 'like', '%' . $param['query']. '%')
            ->orderBy(empty($param['orderBy'])?'id':$param['orderBy'])
            ->paginate($param['limit'], $columns = ['*'], $pageName = 'page', $page);
        $returnData = [
            'count' => $permission->total(),
            'data' => $permission->items()
        ];
        // return response()->json(Helper::createResponseData('21102','读取成功',$returnData));
        return response()->json($returnData);
    }
}