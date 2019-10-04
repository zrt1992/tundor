<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Order;
use App\Task;
use App\User;
use App\UserCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function related_users()
    {

        $userWithCountTen = User::with('categories')->where('count', 3)->whereNotIN('id', [\Auth::id()])->get()->toArray();
        $userIdWithcountTen = [];
        foreach ($userWithCountTen as $users) {
            $userIdWithcountTen [] = $users['id'];
        }

        $current_user = User::with('categories')->where('id', \Auth::id())->first()->toArray();

        $relatedUsers = UserCategory::whereIn('user_id', $userIdWithcountTen)->get()->toArray();

        $currentUserCategories = [];
        if (isset($current_user['categories'])) {
            $currentUserCategories = $current_user['categories'];
        }

        $relatedUsers = $this->calculateRelatedCategories($currentUserCategories, $relatedUsers);
        return response()->json(
            [
                'data' =>
                    [
                        'related_users' => $relatedUsers
                    ]
                ,
                'status_code' => 200
            ], 200);

    }

    public function add_user_categories(Request $request)
    {

        $yesterday = date("Y-m-d", strtotime('-1 days'));
        $user = \Auth::user();

        $categories = $request->all();
        if (!isset($request->all()[0]['category_id'])) {
            return response()->json(
                [
                    'data' =>
                        [
                            'errors' => [['message' => 'No category provided']]
                        ]
                    ,
                    'status_code' => 401
                ], 401);
        }
        // $todayCategories = \App\UserCategory::where('user_id',\Auth::id())->whereDate('created_at', Carbon::today())->get()->toArray();
        $todayCategories = \App\UserCategory::where('user_id', \Auth::id())->where('created_at', '>', Carbon::now()->subMinutes(5)->toDateTimeString())->get()->toArray();

        if (!empty($todayCategories)) {
            return response()->json(
                [
                    'data' =>
                        [
                            'errors' => [['message' => 'You are have already selected category today']]
                        ]
                    ,
                    'status_code' => 401
                ], 401);
        }
        // $userlastdaycategories = \App\UserCategory::where('user_id',\Auth::id())->whereDate('created_at', $yesterday)->get()->toArray();
        $userlastdaycategories = \App\UserCategory::where('user_id', \Auth::id())
            ->where('created_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString())
            ->where('created_at', '<', Carbon::now()->subMinutes(5)->toDateTimeString())
            ->get()->toArray();

        $data = [];
        foreach ($categories as $category) {
            $data[$category['category_id']] =
                [
                    'long' => $category['long'],
                    'lat' => $category['lat'],
                    'color' => $category['color'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
        }
        $user->categories()->attach($data);
        if (empty($userlastdaycategories)) {
            $user->count = 1;
        } else {
            if ((($user->count) + 1) == 3 || $user->count == 3) {
                if ($user->count == 3) {
                    $user->count = 1;
                    $user->save();

                    return response()->json(
                        [
                            'data' =>
                                [
                                    'message' => 'Categories update successfully',
                                    'count' => $user->count
                                ]
                            ,
                            'status_code' => 200
                        ], 200);

                }
                $user->count = $user->count + 1;
                $user->save();
                return response()->json(
                    [
                        'data' =>
                            [
                                'count' => $user->count
                            ]
                        ,
                        'status_code' => 200
                    ], 200);

            } else {

                $user->count = $user->count + 1;
            }
        }
        $user->save();
        return response()->json(
            [
                'data' =>
                    [
                        'message' => 'Categories update successfully',
                        'count' => $user->count
                    ]
                ,
                'status_code' => 200
            ], 200);
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }


    public function calculateRelatedCategories($curentUserCategories, $relatedUsersCategory)
    {
//dump($curentUserCategories);
//dump($relatedUsersCategory);

        $related_cats = [];
        $nearestUserIds = [];

        foreach ($curentUserCategories as $category) {
            $min = 9099999999999;
            $tempuserid = 0;
            $tempcatid = 0;
            foreach ($relatedUsersCategory as $relatedCategory) {

                if ($category['id'] == $relatedCategory['category_id']) {
                    //  if(in_array($relatedCategory['user_id'],$related_users)) continue;
                    $distance = $this->distance($relatedCategory['lat'], $relatedCategory['long'], $category['pivot']['lat'], $category['pivot']['long'], 'k');
                    if ($distance < $min) {
                        $min = $distance;
                        $tempuserid = $relatedCategory['user_id'];
                        $tempcatid = $relatedCategory;
                    }

                }

            }


            $nearestUserIds[] = $tempuserid;
            $related_cats[] = $tempcatid;


        }

        return $related_cats;

    }

    public function get_user_categories(Request $request, $id)
    {
        $catgories = \App\UserCategory::where('category_id', $id)->with('user')->get()->toArray();
        if (empty($catgories)) {
            return response()->json(
                [
                    'data' => [
                        'message' => 'You have no categories yet',
                    ]
                    ,
                    'status_code' => 200
                ], 200);
        }
        return response()->json(
            [
                'data' => $catgories
                ,
                'status_code' => 200
            ], 200);
    }

    public function profile_update(Request $request)
    {
        //JWTAuth::setToken('too.bar.baz')->invalidate();
        $user_id = \Auth::id();
        $user = User::find($user_id);
        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->profile_pic) {
            $profile_link = env('APP_URL') . '/storage/app/' . $request->profile_pic->store('images');
            $user->profile_pic = $profile_link;
        }
        $user->save();
        return response()->json(
            [
                'data' => [
                    'message' => 'Profile Update Sucessfull',
                    'user' => \Auth::user()
                ]
                ,
                'status_code' => 200
            ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json(
            [
                'data' => [
                    'user' => \Auth::user()
                ]
                ,
                'status_code' => 200
            ], 200);
    }
}
