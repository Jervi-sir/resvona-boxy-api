<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $socials = [
        'facebook' =>'',  //
        'twitter' =>'https://www.twitter.com/',
        'linkedin' =>'',  //
        'web' =>'',
        'vcard' =>'',
        'youtube' =>'',  //
        'soundcloud' =>'https://soundcloud.com/',
        'spotify' =>'',
        'instagram' =>'https://www.instagram.com/',
        'tiktok' =>'https://www.tiktok.com/',
        'email' =>'mailto:',
        'tel' =>'tel:',
        'map' =>'map', '',
        'applemusic' =>'',  //
        'whatsapp' =>'tel:',
        'paypal' =>'',  //
        'viber' =>'tel:',
        'pinterest' =>'', //
        'reddit' =>'',  //
        'twitch' =>'https://www.twitch.tv/',
        'tellonym' =>'',  //
        'telegram' =>'',  //
        'steam' =>'',  //
        'flickr' =>'',  //
        'discord' =>'',  //
        'behance' =>'',  //
       
    ];

    public function editPage(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $response = [
            'username' => $user->nickName,
            'bio' => $user->bio,
            'image' => $user->image,
            'socials' => $user->socials,
            'uuid' => $user->uuid,
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
        $user = User::where('name', $request->username)->first();
        $user->bio = $request->bio;
        $user->save();

        return response('bio updated successfully', 201);
    }

    public function name(Request $request)
    {
        $user = User::where('name', $request->username)->first();
        $user->nickName = $request->name;
        $user->save();

        return response('nickName updated successfully', 201);
    }

    public function addSocial(Request $request)
    {
        $user = User::where('name', $request->username)->first();
        //$user = Auth::guard('sanctum')->user();

        $platform = $request->platform;
        $link = $request->link;

        $social_array = json_decode($user->socials);
        $count_socials = count($social_array);

        $json = [
            'id' => $count_socials + 1,
            'platform' => $platform,
            'link' => $link,
            'fullLink' => $this->socials[$platform] . $link,
            'order' => $count_socials + 1,
        ];

        array_push($social_array, $json);

        $user->socials = json_encode($social_array);
        $user->save();

        return response($json, 201);
    }

    public function editSocial(Request $request)
    {
        $user = User::where('name', $request->username)->first();

        $id = $request->id;
        $link = $request->link;

        $social_array = json_decode($user->socials);

        //get the detail from array
        foreach ($social_array as $key => $value) {
            if ($value->id == $id) {
                $social_array[$key]->link = $link;
                $social_array[$key]->fullLink = $this->socials[$social_array[$key]->platform] . $link;
            }
        }

        $user->socials = json_encode($social_array);
        $user->save();

        return response('social edited successfully', 201);
    }

    public function deleteSocial(Request $request)
    {
        $id = $request->id;

        $user = User::where('name', $request->username)->first();

        $social_array = json_decode($user->socials, true);
        $social_final = [];

        foreach($social_array as $key => $value) {
            if($value['id'] == $id) {
                continue;
            } else {
                $json = [
                    'id' => $value['id'],
                    'platform' => $value['platform'],
                    'link' => $value['link'],
                    'order' => $value['order'],
                ];
        
                array_push($social_final, $json);
            }
         }

        $user->socials = json_encode($social_final, true);
        $user->save();

        return response('social edited successfully', 201);
    }


}
