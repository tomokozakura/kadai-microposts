<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    // storeメソッドの中でUser.phpの中で定義したfollowメソッドを使って、
    // ユーザーをフォローできるようにします。
    public function store(Request $request, $id)
    {
        \Auth::user()->follow($id);
        return back();
    }

    // storeメソッドの中でUser.phpの中で定義したfollowメソッドを使って、
    // ユーザーをフォローできるようにします。
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
