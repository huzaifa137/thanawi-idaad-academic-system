<?php

namespace App\Http\Controllers;

use DB;
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
        // $request->validate([
        //     'permissions' => 'required|array|min:1',
        //     'permissions.*.feature' => 'required|string',
        //     'permissions.*.scope' => 'required|string',
        // ]);

        $now = now();

        Permission::query()->update(['is_marked' => false]);

        foreach ($request->permissions as $item) {

            $feature = $item['feature']; 
            $scope = $item['scope']; 

            [$action,$featureName] = explode('_', $feature, 2);

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
        $permissions = DB::table('permissions')
            ->select('name', 'scope', DB::raw('GROUP_CONCAT(feature) as features'))
            ->groupBy('name', 'scope')
            ->orderBy('scope', 'desc')
            ->get();

        $markedFeatures = DB::table('permissions')
            ->where('is_marked', true)
            ->pluck('feature')
            ->toArray();

        return view('UserRights.assign-permissions', compact('permissions', 'markedFeatures'));
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

}
