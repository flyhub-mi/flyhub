<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\RoleDataTable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BaseController;
use Spatie\Permission\Models\Permission;

class RoleController extends BaseController
{
    /**
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * @param RoleDataTable $roleDataTable
     * @return mixed
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('roles.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permission = Permission::get();
        $rolePermissions = [];
        return view('tenant.admin.roles.create', compact('permission', 'rolePermissions'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        Flash::success('Role criado.');

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (is_null($role)) {
            Flash::error('Role não encontrado.');

            return redirect(route('roles.index'));
        }

        $rolePermissions = Permission::join(
            'role_has_permissions',
            'role_has_permissions.permission_id',
            '=',
            'permissions.id',
        )
            ->where('role_has_permissions.role_id', $id)
            ->get();

        return view('tenant.admin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::find($id);

        if (is_null($role)) {
            Flash::error('Role não encontrado.');

            return redirect(route('roles.index'));
        }

        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('tenant.admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);

        if (is_null($role)) {
            Flash::error('Papel não encontrado.');

            return redirect(route('roles.index'));
        }

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        Flash::success('Papel atualizado.');

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();

        Flash::success('Papel excluído com sucesso.');

        return redirect()->route('roles.index');
    }
}
