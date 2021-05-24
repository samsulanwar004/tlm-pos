<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Spatie\Permission\Models\Permission as Permissions;

class PermissionController extends Controller
{

    public function __construct(){
        $this->prefix = 'administrator.permission';
        $this->routePath = 'administrator.permission';
        $this->model = Permission::class;
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
        return view($this->prefix.'.create');
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
            'name' => 'required|string|unique:permissions|max:255'
        ]);

        Permissions::create($request->only(['name']));

        return redirect()->route($this->prefix.'.index')->with('success', 'Success create permission');
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
    public function edit(Permission $permission)
    {
        return view($this->prefix.'.edit', ['data'=> $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255'
        ]);

        $permission->update($request->only(['name']));

        return redirect()->route($this->prefix.'.index')->with('success', 'Success update permission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
    }
}
