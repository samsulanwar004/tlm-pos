<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterOrder;
use App\Helpers\DataStatic;
use App\Rules\Lowercase;

class HistoryController extends Controller
{

    public function __construct(DataStatic $static){
        $this->prefix = 'history';
        $this->routePath = 'history';
        $this->model = MasterOrder::class;
        $this->static = $static;
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

        $query = $this->model::latest()->get();
        $status = $this->static->status_order();

        return datatables()
            ->of($query)
            ->addIndexColumn()
            ->addColumn("status", function ($data) use ($status) {
                return $status[$data->status];
            })
            ->addColumn("action", function ($data) {
                return view("components.datatable.actions", [
                    "showRoute" => route($this->routePath.".edit", $data->id)
                ]);
            })->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $masterOrder = MasterOrder::find($id);
        $status = $this->static->status_order();
        $masterOrder->status = $status[$masterOrder->status];

        return view($this->prefix.'.edit', ['data' => $masterOrder]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterOrder $masterOrder)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => ['required','string','max:255', new Lowercase, $request->input('username') != $tenant->username ? Rule::unique('tenants')->where(function ($query) use ($request) {
                    $query->where('username', $request->input('username'));
                    return $query->whereNull('deleted_at');
                }) : '']
        ]);

        $value = $request->all();

        $update = [
            'modify_by' => $request->user()->id,
            'name' => $value['name'],
            'username' => $value['username'],
            'password' => $value['password'],
            'status' => $value['status'],
        ];

        $tenant->update($update);

        return redirect()->route($this->prefix.'.index')->with('success', 'Success update tenant');
    }
}
