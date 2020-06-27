<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Events\UserHasRemoved;
use App\Notifications\NewUserCreated;
use App\Notifications\NewUserCreatedDB;
use App\Notifications\WelcomeNewUser;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use function foo\func;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $roles = Role::all();

        $acl = [
            'give_permissions' => (Gate::allows('give-permissions')) ? true : false,
        ];



        return view('users.users', compact(['roles', 'acl']));
    }
    function members()
    {

        return view('users.members');
    }

    function profile($user)
    {
        try {
            $user = User::findOrFail($user);
            return view('users.profile', compact(['user']));
        } catch (Exception $e) {
            abort(403);
        }
    }
    function me()
    {
        try {
            $user = auth()->user();
            return view('users.profile', compact(['user']));
        } catch (Exception $e) {
            abort(403);
        }
    }

    public function roles()
    {
        return view('users.roles');
    }
    public function permissions()
    {
        return view('users.permissions');
    }


    function reset($user)
    {
        $acl = [
            'give_permissions' => (Gate::allows('give-permissions')) ? true : false,
        ];
        try {
            $rest = User::findOrFail($user);
            return view('users.reset', compact(['rest','acl']));
        } catch (Exception $e) {
            abort(403);
        }
    }
}
