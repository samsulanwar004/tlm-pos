<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Role as Roles;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct(){
        $this->prefix = 'administrator.role';
        $this->routePath = 'administrator.role';
        $this->model = Role::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable($request);
        }
      
        return view($this->prefix.'.index');
    }

    public function datatable(Request $request){
        $query = $this->model::latest()->get();

        return datatables()
            ->of($query)
            ->addColumn("permissions", function($data) {
                return view("components.datatable.badges", ['permissions' => $data->permissions ]);
            })
            ->addColumn("action", function ($data) {
                return view("components.datatable.actions", [
                    "editRoute" => route($this->routePath.".edit", $data->id),
                    "deleteRoute" => route($this->routePath.".destroy", $data->id),
                ]);
            })->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view($this->prefix.'.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles|max:255',
            'permission' => 'required|array',
            'permission.*' => 'required|string|distinct'
        ]);

        $role = Roles::create($request->only(['name']));
        $role->givePermissionTo($request->input('permission'));

        return redirect()->route($this->prefix.'.index')->with('success', 'Success create role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $selectedPermission = $role->permissions->mapWithKeys(function($item) {
            return [$item['name'] => $item['name']];
        })->all();

        $permissions = Permission::all();

        return view($this->prefix.'.edit', ['data'=> $role, 'permissions' => $permissions, 'selectedPermission' => $selectedPermission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'permission' => 'required|array',
            'permission.*' => 'required|string',
        ]);

        $role->update($request->only(['name']));

        $roles = Roles::findById($role->id);

        $roles->revokePermissionTo($request->input('old_selected'));

        $roles->givePermissionTo($request->input('permission'));

        return redirect()->route($this->prefix.'.index')->with('success', 'Success update role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
    }
}
