<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateGeneralSetting;

class SettingController extends Controller
{
    public function index()
    {
        return redirect()->route('settings::getGeneral');
    }

    public function getGeneral(Request $request)
    {
        $user = $request->user();

        return view('settings/general', compact('user'));
    }

    public function postGeneral(UpdateGeneralSetting $request)
    {
        $user = $request->user();
        $data = $request->all();
        
        if (isset($data['password']) and $data['password']) {
            $data['password'] = bcrypt($data['password']);
        }
        
        $user->update($data);

        return redirect()->back()->withStatus('Cập nhật thông tin thành công');
    }
}
