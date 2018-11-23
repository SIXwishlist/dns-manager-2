<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc');

        if ($request->has('q')) {
            $users = $users->where('name', 'like', '%' . $request->input('q') . '%')
                ->orWhere('email', 'like', '%' . $request->input('q') . '%');
        }

        $users = $users->paginate(30);

        return view('user/list', compact('users'));
    }

    public function add(Request $request)
    {
        return view('user/add');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_admin'] = (int) @$data['is_admin'];
        $data['password'] = bcrypt(@$data['password']);
        $user = new User($data);
        $user->save();

        return redirect()->route('user::list')->withStatus('Đã thêm người dùng mới');
    }

    public function edit(User $user)
    {
        return view('user/edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $data = $request->all();
        $data['is_admin'] = (int) @$data['is_admin'];

        if (isset($data['password']) and $data['password']) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return redirect()->back()->withStatus('Cập nhật thông tin người dùng thành công');
    }

    public function delete(User $user, Request $request)
    {
        $user->delete();
        $user->domains()->delete();

        if ($request->ajax()) {
            return ['success' => true];
        }

        return redirect()->back()->withStatus('Đã xoá');
    }
}
