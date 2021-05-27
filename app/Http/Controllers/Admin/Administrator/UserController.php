<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Rules\Lowercase;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct(){
        $this->prefix = 'administrator.user';
        $this->routePath = 'administrator.user';
        $this->model = User::class;
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

    public function datatable(Request $request) {

        $user = $request->user();

        $query = $this->model::latest()->get();

        return datatables()
            ->of($query)
            ->addColumn("role", function($data) {
                return view("components.datatable.badges", ['role' => $data->getRoleNames() ]);
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

        $user = $this->getUserActive();

        $roles = Role::all();

        return view($this->prefix.'.create', compact('roles', 'user'));
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
            'name' => 'required|string|max:255',
            'username' => ['required','string','unique:users','max:255', new Lowercase],
            'password' => 'required|string|min:8|max:255',
        ]);

        $data = $this->model::create($request->only(['name', 'username', 'password']));
        $data->assignRole($request->only(['role']));

        return redirect()->route($this->prefix.'.index')->with('success', 'Success create user');
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
    public function edit(User $user)
    {
        $userLogin = $this->getUserActive();

        $roles = Role::all();
        $user->role_name = $user->getRoleNames()[0];

        return view($this->prefix.'.edit', ['data' => $user, 'roles' => $roles, 'user' => $userLogin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => ['required','string','max:255', new Lowercase, $request->input('username') != $user->username ? Rule::unique('users')->where(function ($query) use ($request) {
                    $query->where('username', $request->input('username'));
                    return $query->whereNull('deleted_at');
                }) : '']
        ]);

        $user->update($request->only(['name', 'username', 'password']));

        if ($request->input('role') != null && $user->roles->pluck('name')->first() != $request->input('role')) {

            $user->roles->pluck('name')->first() != null ? $user->removeRole($user->roles->pluck('name')->first()) : '';
            $user->assignRole($request->only(['role']));
        }

        return redirect()->route($this->prefix.'.index')->with('success', 'Success update user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
