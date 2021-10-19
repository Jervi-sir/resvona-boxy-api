<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PersonalAccessToken;
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
        'map' =>'map',
        'applemusic' =>'',  //
        'whatsapp' =>'tel:',  //https://wa.m/21355
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
        'dribbble' =>'',  //
        'snapchat' =>'',  //
    ];

    private function userId($token) {
        $token_array = explode(" ", $token);
        $token_id = $token_array[0];
        $token = PersonalAccessToken::find($token_id);
        $user_id = $token->tokenable_id;

        return $user_id;
    }
    //no sure yet
    public function editPage(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $response = [
            'username' => $user->nickName,
            'bio' => $user->bio,
            'socials' => $user->socials,
            'uuid' => $user->uuid,
        ];

        return response($response, 201);
    }
    
    //show user no login required
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
            'socials' => $user->socials,
        ];

        return response($response, 201);
    }

    public function showOld($uuid) 
    {
        if(strlen($uuid) < 20) {
            $user = User::find($uuid);
            $response = [
                'username' => $user->nickName,
                'bio' => $user->bio,
                'socials' => $user->socials,
            ];

            return response($response, 201);
        }
        $firstOff = substr($uuid, 9);   //takeoff first 9 numbers
        $split = explode("f8f7ee9", $firstOff); //into an array
        $getId = $split[0];
        $serverHashedId = sha1($getId);
        $urlHashedId = $split[1];
        
        if($serverHashedId == $urlHashedId) 
        {
            $user = User::find($getId);
            $response = [
                'username' => $user->nickName,
                'bio' => $user->bio,
                'socials' => $user->socials,
            ];
        }
        else
        {
            return response('error', 404);
        }

        return response($response, 201);

    }


    //update bio
    public function bio(Request $request) {
        
        $user = User::find($this->userId($request->token));
        $user->bio = $request->bio;
        $user->save();

        return response('bio updated successfully', 201);
    }

    public function name(Request $request)
    {
        $user = User::find($this->userId($request->token));
        $user->nickName = $request->name;
        $user->save();

        return response('nickName updated successfully', 201);
    }

    public function addSocial(Request $request)
    {
        $user = User::find($this->userId($request->token));
        //$user = Auth::guard('sanctum')->user();

        $platform = $request->platform;
        $link = $request->link;

        $social_array = json_decode($user->socials);
        $count_socials = count($social_array);
        $last_id = 0;
        //get the detail from array
        foreach ($social_array as $key => $value) {
            if ($key == $count_socials - 1) {
                $last_id = $social_array[$key]->id;
            }
        }

        $json = [
            'id' => $last_id + 1,
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
        $user = User::find($this->userId($request->token));

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

        $user = User::find($this->userId($request->token));

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
