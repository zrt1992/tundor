<?php
namespace App\Http\Controllers;
use App\Models\Todo;
use App\Order;
use App\Task;
use App\User;
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
    public function add_user_categories(Request $request)
    {
        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
        $user = \Auth::user();
        $categories = $request->all();
        if(!isset($request->all()[0]['category_id'])){
            return response()->json(
                [
                    'data'=>
                        [
                            'errors' => [['message'=>'No category provided']]
                        ]
                    ,
                    'status_code' => 401
                ], 401);
        }
        $todayCategories = \App\UserCategory::where('user_id',\Auth::id())->whereDate('created_at', Carbon::today())->get()->toArray();
        if(!empty($todayCategories)){
            return response()->json(
                [
                    'data'=>
                        [
                            'errors' => [['message'=>'You are have already selected category today']]
                        ]
                    ,
                    'status_code' => 401
                ], 401);
        }
        $userlastdaycategories = \App\UserCategory::where('user_id',\Auth::id())->whereDate('created_at', $yesterday)->get()->toArray();
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
            if ($user->count == 10) {
                $user->count = 1;
                \App\UserCategory::where('user_id',\Auth::id())->whereDate('created_at', $yesterday)->get()->toArray();
            } else {
                $user->count = $user->count + 1;
            }
        }
        $user->save();
        return response()->json(
            [
                'data' =>
                    [
                        'message' => 'Categories update successfully'
                    ]
                ,
                'status_code' => 200
            ], 200);
    }
    public function get_user_categories(Request $request, $id)
    {
        $catgories = \App\UserCategory::where('category_id',$id)->with('user')->get()->toArray();
        if(empty($catgories)) {
            return response()->json(
                [
                    'data'=> [
                        'message' => 'You have no categories yet',
                    ]
                    ,
                    'status_code' => 200
                ], 200);
        }
        return response()->json(
            [
                'data'=> $catgories
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