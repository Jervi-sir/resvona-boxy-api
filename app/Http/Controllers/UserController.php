<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function editPage(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $response = [
            'username' => $user->nickName,
            'bio' => $user->bio,
            'image' => $user->image,
            'socials' => $user->socials,
        ];

        return response($response, 201);
    }
    
    public function show($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if($user == NULL) 
        {
            return response('error', 404);
        }

        $response = [
            'username' => $user->nickName,
            'bio' => $user->bio,
            'image' => $user->image,
            'socials' => $user->socials,
        ];

        return response($response, 201);
    }

    public function image(Request $request)
    {
        $image = $request->image;

        $user = Auth::guard('sanctum')->user();
        $user->image = $image;
        $user->save();

        return response('image updated successfully', 201);
    }

    public function bio(Request $request)
    {
        $bio = $request->bio;

        $user = Auth::guard('sanctum')->user();
        $user->bio = $bio;
        $user->save();

        return response('bio updated successfully', 201);
    }

    public function name(Request $request)
    {
        $nickName = $request->nickName;

        $user = Auth::guard('sanctum')->user();
        $user->nickName = $nickName;
        $user->save();

        return response('nickName updated successfully', 201);
    }

    public function addSocial(Request $request)
    {
        $platform = $request->platform;
        $link = $request->link;
        $user = Auth::guard('sanctum')->user();
        $social_array = json_decode($user->socials);
        $count_socials = count($social_array);

        $json = [
            'id' => $count_socials + 1,
            'platform' => $platform,
            'link' => $link,
            'order' => $count_socials + 1,
        ];

        array_push($social_array, $json);

        $user->socials = json_encode($social_array);
        $user->save();

        return response('social added successfully', 201);

    }

    public function editSocial(Request $request)
    {
        $id = $request->id;
        $link = $request->link;

        $user = Auth::guard('sanctum')->user();

        $social_array = json_decode($user->socials);

        //get the detail from array
        foreach ($social_array as $key => $value) {
            if ($value->id == $id) {
                $social_array[$key]->link = $link;
            }
        }

        $user->socials = json_encode($social_array);
        $user->save();

        return response('social edited successfully', 201);
    }

    public function deleteSocial(Request $request)
    {
        $id = $request->id;

        $user = Auth::guard('sanctum')->user();
        $social_array = json_decode($user->socials);

        foreach ($social_array as $key => $value) {
            if ($value->id == $id) {
                unset($social_array[$key]);
            }
        }

        $user->socials = json_encode($social_array);
        $user->save();

        return response('social edited successfully', 201);
    }


}
