<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Phone;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'email' => 'required|email|max:50',
            'dateOfBirth' => 'required|date',
            'isActive' => 'required|boolean',
            'phoneNumber' => 'required|max:13|regex:/^\+36[0-9]{9,10}$/'
        ]);
        if($validation->fails())
        {
            return response()->json($validation->errors(),406);
        }
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

    public function read(Request $request)
    {
        $order = $request->query('orderby');
        //Query building
        $data = null;
        if($order == 'name')
        {
            $data = User::orderBy('name')->paginate();
        }
        else if($order == 'email')
        {
            $data = User::orderBy('email')->paginate();
        }
        else if($order == 'phoneNumber')
        {
            $data = User::orderBy('phoneNumber')->paginate();
        }
        else if($order == 'dateOfBirth')
        {
            $data = User::orderBy('dateOfBirth')->paginate();
        }
        else if($order == 'isActive')
        {
            $data = User::orderBy('isActive')->paginate();
        }
        else
        {
            $data = User::paginate();
        }
        return new UserCollection($data);
    }

    public function update(Request $request, User $user)
    {

        try{
        $validation = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'email' => 'required|email|max:50',
            'dateOfBirth' => 'required|date',
            'isActive' => 'required|boolean',
            'phoneNumber' => 'required|max:13|regex:/^\+36[0-9]{9,10}$/'
        ]);
        if($validation->fails())
        {
            return response()->json($validation->errors(),406);
        }


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
            $phone = $user->phones->where('isDefault','True');
            $phone = $request->phoneNumber;
            $phone->save();
        }

        $user->save();
        return response()->json(['message'=>'User '.$user->id.' updated!'],200);
    }
catch(QueryException $e)
{
    return response()->json(['message'=>'Invalid user!'],404);
}
    }

    public function delete($user)
    {
        try{
            $user = User::find('id',$user);
            $user->delete();
            return response()->json(['message'=>'User deleted!'],200);
        }catch(QueryException $e)
        {
            return response()->json(['message'=>'Invalid user!'],404);
        }

    }
}
