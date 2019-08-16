<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    // storeメソッドの中でUser.phpの中で定義したfollowメソッドを使って、
    // ユーザーをフォローできるようにします。
    public function store(Request $request, $id)
    {
        \Auth::user()->favorite($id);
        return back();
    }

    // storeメソッドの中でUser.phpの中で定義したfollowメソッドを使って、
    // ユーザーをフォローできるようにします。
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }
}
