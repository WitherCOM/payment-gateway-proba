<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Phone;
use Illuminate\Support\Facades\DB;
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
        $user = new User($request->all());
        $user->save();

        $phone = new Phone;
        $phone->phoneNumber = $request->phoneNumber;
        $phone->isDefault = true;
        $phone->user()->associate($user);
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
            $data = User::select('users.*',DB::raw('(SELECT phoneNumber FROM phones WHERE users.id = phones.id and phones.isDefault = 1) as phoneNumber'))->orderBy('phoneNumber')->paginate();
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
                'name' => 'max:30',
                'email' => 'email|max:50',
                'dateOfBirth' => 'date',
                'isActive' => 'boolean',
                'phoneNumber' => 'max:13|regex:/^\+36[0-9]{9,10}$/'
            ]);
            if($validation->fails())
            {
                return response()->json($validation->errors(),406);
            }

            $user->update($request->all());
            $user->defaultPhone->update($request->all());

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
