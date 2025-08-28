<?php

namespace App\Http\Controllers;

use App\DataTables\CmsDataTable;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Users';
        $resource = 'user';
        $data = User::getAllUsers();
        $columns = ['Full name', 'email', 'contact number', 'role', 'action'];
        $subData = Role::getAllRoles();
        return $dataTable->render('applicant.index', compact(
            'data',
            'columns',
            'dataTable',
            'resource',
            'page_title',
            'subData'
        ));
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->userStore($request->validated());

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user()->id)
            ->log('User ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' created an account for ' . $user->first_name . ' ' . $user->last_name);

        return redirect()   
            ->route(Auth::user()->getRoleNames()->first() . '.user.index')
            ->with('success', 'You have successfully create an account for ' . $user->first_name . ' ' . $user->last_name);
    }

    public function update(User $user, UserRequest $request)
    {
        $user = $this->userService->userUpdate($request->validated(), $user);

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user()->id)
            ->log('User ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' updated the account of ' . $user->first_name . ' ' . $user->last_name);

        return redirect()   
            ->route(Auth::user()->getRoleNames()->first() . '.user.index')
            ->with('success', 'You have successfully updated the account of ' . $user->first_name . ' ' . $user->last_name);
    }

    public function show(User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        $userName = $user->first_name . ' ' . $user->last_name;
        $user = $this->userService->destroyUser($user);

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user()->id)
            ->log('User ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' deleted the account of ' . $userName);

        return redirect()   
            ->route(Auth::user()->getRoleNames()->first() . '.user.index')
            ->with('success', 'You have successfully deleted the account of ' . $userName);
    }
}
