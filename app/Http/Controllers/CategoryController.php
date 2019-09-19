<?php

namespace App\Http\Controllers;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
      //  $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // api/categories
        // show only those categories to user which has been added today by the admin
        //$todayCategories = App\Category::where('user_id', \Auth::id())->whereDate('created_at', Carbon::today())->get()->toArray();
        $todayCategories = Category::whereDate('created_at', Carbon::today())->get()->toArray();
       // dd(Carbon::now());
         //dd($todayCategories);
        if (!empty($todayCategories)) {
            $categories = Category::get()->all();
            $data = [];
            $data['status_code'] = 200;
            $data['data']['categories'] = $todayCategories;
            return response()->json($data, 200);
        } else {
            return response()->json(
                [
                    'data' =>
                        [
                            'errors' => [['message' => 'No catefories were added today by the admin']],
                            'categories' => $todayCategories
                        ]
                    ,
                    'status_code' => 401
                ], 401);
        }

    }

    /**
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $category = new Category();
        $category->fill($request->all());
        $category->save();
        $data=[];
        $data['status_code'] = 200;
        $data['data']['message'] = 'category saved sucessfully';

        return response()->json($data, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test(){
        dd('asd');
    }
}
