<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Image;
use App\Models\Review;
use Lang;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::allUser();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'level' => config('custom.level.admin'),
            'password' => bcrypt(config('custom.default_password')),
        ]);

        // Images table
        $userId = User::userId($request->email);
        Image::create([
            'image' => config('custom.image.avatar_default'),
            'imageable_id' => $userId,
            'imageable_type' => config('custom.image.user'),
        ]);

        return redirect()->route('admin.user.index')->with('msg', Lang::get('custom.msg.user_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            User::findOrFail($id);
            $user = User::userWithImage($id);

            return view('admin.users.show', compact('user'));
            
        } catch (ModelNotFoundException $e) {
            return view('admin.partials.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        User::find($id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        if ($request->password != null) {
            User::find($id)->update([
                'password' => bcrypt($request->password),
            ]);
        }

        if ($request->avatar != null) {
            $filename = $request->avatar->move(config('custom.image.path_avatar'), $request->avatar->getClientOriginalName());
            $image = Image::imageFirst($id, config('custom.image.user'))->update([
                'image' => $filename,
                'imageable_id' => $id,
                'imageable_type' => config('custom.image.user'),
            ]);
        }

        return redirect()->route('admin.user.show', $id)->with('msg', Lang::get('custom.msg.user_edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Review::reviewUser($request->userId)->delete();
        User::destroy($request->userId);

        return response()->json(['msg' => Lang::get('custom.msg.user_deleted')]);
    }
}
