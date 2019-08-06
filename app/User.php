<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    // $user が フォローしている User 達を取得
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    // $user をフォローしている User 達を取得可能
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    // withTimestamps() は中間テーブルにも created_at と updated_at を
    // 保存するためのメソッドでタイムスタンプを管理することができるようになります。
    
    
    // フォロー／アンフォロー出来るように定義してます。
    // ⇒follow()とunfollow()メソッドを追記
    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない  
            // ||はor $exist又は$its_meがTrue⇒フォロー済み又は自分の場合はノーアクション
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    
}
