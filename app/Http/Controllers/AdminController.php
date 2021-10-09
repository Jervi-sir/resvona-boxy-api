<?php

namespace App\Http\Controllers;

use Faker\Factory;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUsers()
    {
        $users = User::all();

        return view('user.all');
    }

    public function addUsers()
    {
        return view('user.create');
    }

    public function createUsers(Request $request)
    {
        for($i = 0; $i < $request->amount; $i++)
        { 
            $faker = Factory::create();
            $uuid_link = Str::uuid()->toString();

            do {
                $user_name = 'boxy' . $faker->randomNumber($nbDigits = 6, $strict = false);
            }
            while(User::where('name', $user_name)->count() != 0);
            
            $user_password = 'delta' . $faker->randomNumber($nbDigits = 6, $strict = false);
            
            $user = new User();
            $user->name = $user_name;
            $user->email = $user_name . '@resvona.com';

            $user->password = Hash::make($user_password);

            $user->nickName = 'set your usernmae';
            $user->bio = 'set your bio';
            $user->socials = '[]';
            $user->passNoHash = $user_password;
            $user->uuid = $uuid_link;
            $user->save();
        }
    }

}
