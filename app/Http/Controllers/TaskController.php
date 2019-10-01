<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Order;
use App\Task;
use App\User;
use App\UserCategory;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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


        $related_users = [];
        $nearestUserIds = [];
        foreach ($curentUserCategories as $category) {
            $min = 9099999999999;
            $tempuserid = 0;
            foreach ($relatedUsersCategory as $relatedCategory) {

                if($category['id']==$relatedCategory['category_id']){
                    if(in_array($relatedCategory['user_id'],$related_users)) continue;
                    $distance = $this->distance($relatedCategory['lat'],$relatedCategory['long'],$category['pivot']['lat'],$category['pivot']['long'],'k');
                    if($distance<$min) {
                        $min = $distance;
                        $tempuserid = $relatedCategory['user_id'];
                    }

                }

            }
            $nearestUserIds[] = $tempuserid;



        }
        dd($nearestUserIds);
        die;
        dump($related_users);
        die;


    }
    public function index()
    {
        //dd('hello');
        $user = User::where('id','1')->get()->first()->toArray();
        $userWithCountTen = User::with('categories')->where('count', 10)->whereNotIN('id', [3])->get()->toArray();
        $userIdWithcountTen = [];
        foreach ($userWithCountTen as $users) {
            $userIdWithcountTen [] = $users['id'];
        }
        $user = User::with('categories')->where('id', 3)->first()->toArray();

        $relatedUsers = UserCategory::whereIn('user_id',$userIdWithcountTen)->get()->toArray();
        $currentUserCategories = [];
        if(isset($user['categories'])){
            $currentUserCategories = $user['categories'];
        }
        $this->calculateRelatedCategories($currentUserCategories, $relatedUsers);
        dd($relatedUsers);
        dd($userIdWithcountTen);
        dd($userWithCountTen);
        $user = User::with('categories')->where('id', 3)->first()->toArray();
        dd($user);
        $this->calculateRelatedCategories($user['categories'],);
        User::where('count', 10)->whereNotIN('id', [3])->get()->toArray();

        $user = new User();
        $user->name = "zulfi khan";
        $user->email = "aliii@khan.com";
        $user->email_verified_at = now();
        $user->password = bcrypt("password");
        $user->save();

        $user->orders()->create([
            'qty' => 15,
            'total' => 154
        ]);
        dd($user->save());

        bcrypt('password');

        $tasks = Task::orderBy('id', 'asc')->get();
        //$tasks['abc'] = 'this is errors';
        return response()
            ->json($tasks, 200);
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        return response()
            ->json(['status' => true, 'message' => "Email sent successfully."]);

        dd('hi');
        dd($validated = $request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        dump($task);
        die;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->task_name = $request->get('name');
        $task->save();
        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
