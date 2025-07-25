<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserRightsAndPreviledges extends Controller
{

    public function setup()
    {

        $teachers = Teacher::where('school_id', Session('LoggedSchool'))->get();
        $classRecord = [];

        return view('UserRights.all-school-users', compact(['teachers', 'classRecord']));
    }

    public function allRoles()
    {
        $roles = Role::orderBy('name')->get();

        return view('UserRights.create-role', compact(['roles']));
    }

    public function storeRole(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'scope' => 'required',
        ]);

        Role::create($validated);

        return response()->json(['success' => true, 'message' => 'Role created successfully.']);
    }

    public function allPermissions()
    {
        $permissions = DB::table('permissions')
            ->select('name', 'scope', DB::raw('GROUP_CONCAT(feature) as features'))
            ->groupBy('name', 'scope')
            ->orderBy('scope', 'desc')
            ->get();

        return view('UserRights.create-permissions', compact('permissions'));
    }


    public function storePermissionRole(Request $request)
    {
        $request->validate([
            'permission_feature' => 'required',
            'scope' => 'required',
        ]);

        $permission_feature_name = Helper::item_md_name($request->permission_feature);

        $permission_exists = Permission::where('name', $request->permission_feature)
            ->where('scope', $request->scope)
            ->exists();

        if ($permission_exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission was already created.',
            ], 409);
        }

        $actions = ['add', 'view', 'delete', 'edit'];
        $permissions = [];

        foreach ($actions as $action) {
            $permissions[] = [
                'feature' => $action . '_' . $permission_feature_name,
                'name' => $request->permission_feature,
                'scope' => $request->scope,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Permission::insert($permissions);

        return response()->json(['success' => true, 'message' => 'Permissions created successfully.']);
    }

    public function storeMultiplePermissions(Request $request)
    {
        $now = now();

        Permission::query()->update(['is_marked' => false]);

        foreach ($request->permissions as $item) {

            $feature = $item['feature'];
            $scope = $item['scope'];

            [$action, $featureName] = explode('_', $feature, 2);

            $permission_id = Helper::item_md_id($featureName);

            Permission::updateOrCreate(
                ['feature' => $feature, 'scope' => $scope, 'name' => $permission_id],
                [
                    'name' => $permission_id,
                    'is_marked' => true,
                    'updated_at' => $now,
                ]
            );
        }
        return response()->json(['success' => true, 'message' => 'Permissions saved successfully.']);
    }

    public function assignPermissions()
    {
        $roles = Role::orderBy('name', 'asc')->get();

        $permissions = DB::table('permissions')
            ->select('name', 'scope', DB::raw('GROUP_CONCAT(feature) as features'))
            ->groupBy('name', 'scope')
            ->orderBy('scope', 'desc')
            ->get();

        $markedFeatures = DB::table('permissions')
            ->where('is_marked', true)
            ->pluck('feature')
            ->toArray();

        $rolePermissions = DB::table('permission_role')->get()->groupBy('role_id');

        $users = User::all();

        return view('UserRights.assign-permissions', compact('permissions', 'markedFeatures', 'roles', 'rolePermissions', 'users'));
    }

    public function storeRolePermissions(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'string',
        ]);

        $permissionId = $request->permissions[0];
        $permissionScope = $request->permissions_scope[0];

        $checkExistance = DB::table('permission_role')
            ->where('permission_id', $permissionId)
            ->where('role_id', $roleId)
            ->where('permission_scope', $permissionScope)
            ->first();

        if (!$checkExistance) {
            DB::table('permission_role')->insert([
                'permission_id' => $permissionId,
                'role_id' => $roleId,
                'permission_scope' => $permissionScope,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permissions updated successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission already exists!'
            ]);
        }
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'scope' => 'required'
        ]);

        $role->update($validated);

        return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
    }

    public function deleteRole($id)
    {
        Role::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function destroyGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'scope' => 'required|string',
        ]);

        $deleted = Permission::where('name', $request->name)
            ->where('scope', $request->scope)
            ->delete();

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Permission group deleted successfully.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No matching permissions found.'
        ], 404);
    }

    public function removePermission(Request $request, $roleId)
    {

        $roleId = $request->role_id;
        $permissionId = $request->permission_id;
        $permissionScope = $request->permission_scope;

        $permissionRole = DB::table('permission_role')
            ->where('permission_id', $permissionId)
            ->where('role_id', $roleId)
            ->where('permission_scope', $permissionScope)
            ->first();

        if ($permissionRole) {
            DB::table('permission_role')
                ->where('permission_id', $permissionId)
                ->where('role_id', $roleId)
                ->where('permission_scope', $permissionScope)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permission removed successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found!'
            ]);
        }
    }

    public function assignUserToRole(Request $request)
    {
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        if ($user && $role) {

            $existingAssignment = DB::table('role_user_school')
                ->where('user_id', $user->id)
                ->where('role_id', $role->id)
                ->first();

            if ($existingAssignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'User already has this role.'
                ]);
            }

            DB::table('role_user_school')->insert([
                'user_id' => $user->id,
                'role_id' => $role->id,
            ]);

            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'User or Role not found'], 400);
    }

    public function removeUserFromRole(Request $request)
    {
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        if ($user && $role) {
            $user->roles()->detach($role->id);

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Failed to remove user from role.'], 400);
    }

    public function searchUsersByQuery(Request $request)
    {

        $query = $request->input('query');
        $role_id = $request->input('role_id');

        // dd($role_id);
        // dd($query);


        $users = User::where('user_role', $role_id)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('username', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            })
            // ->take(10)
            ->get();

        return response()->json(['users' => $users]);
    }


}
