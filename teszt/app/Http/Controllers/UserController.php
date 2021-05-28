<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Phone;

class UserController extends Controller
{

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email|max:50',
            'dateOfBirth' => 'required|date',
            'isActive' => 'required|boolean',
            'phoneNumber' => 'required|max:13|regex:/^\+36[0-9]{9,10}$/'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->dateOfBirth = $request->dateOfBirth;
        $user->isActive = $request->isActive;
        $user->save();

        $phone = new Phone;
        $phone->user_id = $user->id;
        $phone->phoneNumber = $request->phoneNumber;
        $phone->isDefault = true;
        $phone->save();

        return response()->json(['message'=>'User created!'],200);
    }

    public function read($id)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'max:30',
            'email' => 'email|max:50',
            'dateOfBirth' => 'date',
            'isActive' => 'boolean',
            'phoneNumber' => 'max:13|regex:^\+36[0-9]{9,10}$'
        ]);

        if($request->has('name'))
        {
            $user->name = $request->name;
        }

        if($request->has('email'))
        {
            $user->email = $request->email;
        }

        if($request->has('dateOfBirth'))
        {
            $user->dateOfBirth = $request->dateOfBirth;
        }

        if($request->has('isActive'))
        {
            $user->isActive = $request->isActive;
        }

        if($request->has('phoneNumber'))
        {
            $user->phone->phoneNumber = $request->phoneNumber;
            $user->phone->save();
        }

        $user->save();
        return response()->json(['message'=>'User '.$user->id.' updated!'],200);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json(['message'=>'User deleted!'],200);
    }
}
