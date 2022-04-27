<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tenant;
use App\Models\Xplayer;
use App\Helpers\DataStatic;
use App\Rules\Lowercase;
use App\Services\ClientService;

class TenantController extends Controller
{

    public function __construct(DataStatic $static){
        $this->prefix = 'master.tenant';
        $this->routePath = 'master.tenant';
        $this->model = Tenant::class;
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
        $status = $this->static->status();

        return datatables()
            ->of($query)
            ->addColumn("status", function ($data) use ($status) {
                return $status[$data->status];
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
        $status = $this->static->status();

        return view($this->prefix.'.create', compact('status'));
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
            'username' => ['required','string','unique:tenants','max:255', new Lowercase],
            'password' => 'required|string|min:8|max:255',
        ]);

        $value = $request->all();

        $insert = [
            'created_by' => $request->user()->id,
            'name' => $value['name'],
            'username' => $value['username'],
            'password' => $value['password'],
            'status' => $value['status'],
        ];

        $data = $this->model::create($insert);

        return redirect()->route($this->prefix.'.index')->with('success', 'Success create tenant');
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
    public function edit(Tenant $tenant)
    {

        $status = $this->static->status();

        return view($this->prefix.'.edit', ['data' => $tenant, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant)
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

        $lastStatus = $tenant->status;

        $tenant->update($update);

        if($value['status'] == 1 && $lastStatus == 0) {

            $xplayer = Xplayer::where('user_id', $tenant->id)
                ->select('player_id')
                ->first();

            if ($xplayer) {

                $url = config('services.key_url_onesignal');
                $token = config('services.key_api_onesignal');
                $appid = config('services.key_appid_onesignal');

                $header = [
                    'Basic' => $token,
                ];

                $data = [
                    'app_id' => $appid,
                    'headings' => [
                        'en' => 'Register'
                    ],
                    'contents' => [
                        'en' => 'Account anda telah active, silahkan login.'
                    ],
                    'include_player_ids' => [$xplayer->player_id]
                ];

                $client = (new ClientService)->request('post', $url, 'json', $header, $data);
            }
        }

        return redirect()->route($this->prefix.'.index')->with('success', 'Success update tenant');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
    }
}
