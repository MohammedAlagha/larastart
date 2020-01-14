<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProfileRequest;
use App\Http\Requests\Dashboard\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
      //  $this->authorize('isAdmin');
    }


    public function index()
    {
        $this->authorize('isAdmin');
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        return User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'type'=>$request['type'],
            'bio'=>$request['bio'],
            'photo'=>$request['photo'],
            'password'=>Hash::make($request['password'])
        ]);
    }


    public function updateProfile(ProfileRequest $request)
    {
        $user = auth('api')->user();
        $current_photo = $user->photo;

        if ($request->photo != $current_photo) {
            $name = time().'.'.explode('/',explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1]; //to extact file name from base 64

            Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);


            if ($current_photo != 'default.png') {
                Storage::disk('public_uploads')->delete('/profile/' . $current_photo);
            }
        }

        if (!empty($request->Password)) {
            $request->merge(['password'=>Hash::make($request->Password)]);
        }

        $user->update($request->all());

        return ['message'=>'Success'];
    }


    public function profile()
    {
        return auth('api')->user();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $user = User::findOrFail($id);

        $user->update($request->except('password'));
        $user->update(['password'=>Hash::make($request['password'])]);
        return ['message' => 'Updated the user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $user = User::findOrFail($id);

        $user->delete();

        return ['message'=>'User Deleted'];
    }
}
