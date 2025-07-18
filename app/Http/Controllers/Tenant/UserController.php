<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\DataTables\Tenant\UserDataTable;
use App\Http\Controllers\BaseController;
use Spatie\Permission\Models\Role;
use App\Repositories\Tenant\UserRepository;

class UserController extends BaseController
{
    /** @var  UserRepository */
    private $modelRepository;

    /**
     * UserController constructor.
     * @param UserRepository $modelRepository
     */
    public function __construct(UserRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param UserDataTable $userDataTable
     * @return \Illuminate\View\View
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('tenant.settings.users.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::get()->pluck('name', 'name');

        return view('tenant.settings.users.create')->with('roles', $roles);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $user = $this->modelRepository->create($input);
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        Flash::success('Usuário criado.');

        return redirect(route('users.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->modelRepository->find($id);

        if (is_null($user)) {
            Flash::error('Usuário não encontrado.');

            return redirect(route('users.index'))->with('status', 'Profile updated!');
        }

        $user->load('roles');

        return view('tenant.settings.users.show')->with('user', $user);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->modelRepository->find($id);

        if (is_null($user)) {
            Flash::error('Usuário não encontrado.');

            return redirect(route('users.index'));
        }

        $user->load('roles');
        $roles = Role::get()->pluck('name', 'name');

        return view('tenant.settings.users.edit')
            ->with('user', $user)
            ->with('roles', $roles);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $user = $this->modelRepository->find($id);

        if (is_null($user)) {
            Flash::error('Usuário não encontrado.');

            return redirect(route('users.index'));
        }

        $user = $this->modelRepository->update($request->input(), $id);
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);

        Flash::success('Usuário atualizado.');

        return redirect(route('users.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = $this->modelRepository->find($id);

        if (is_null($user)) {
            Flash::error('Usuário não encontrado.');

            return redirect(route('users.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success('Usuário excluído.');

        return redirect(route('users.index'));
    }
}
