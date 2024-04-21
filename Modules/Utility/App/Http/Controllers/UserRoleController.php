<?php

namespace Modules\Utility\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Utility\App\Http\Requests\StoreRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('utility::user-role.index', [
            'roles' => Role::orderBy('id','DESC')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('utility::user-role.create', [
        //     'permissions' => Permission::get()
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        // $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        
        // $role->syncPermissions($permissions);

        return redirect()->route('utility.user-role.index')
                ->withSuccess('New role is added successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('utility::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('utility::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
