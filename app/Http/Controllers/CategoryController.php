<?php

namespace App\Http\Controllers;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todayCategories = \App\UserCategory::where('user_id', \Auth::id())->whereDate('created_at', Carbon::today())->get()->toArray();
        if (empty($todayCategories)) {

            $categories = Category::get()->all();
            $data = [];
            $data['status_code'] = 200;
            $data['data']['categories'] = $categories;
            return response()->json($data, 200);
        } else {
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $category = new Category();
        $category->fill($request->all());
        $category->save();
        $data = [];
        $data['status_code'] = 200;
        $data['data']['message'] = 'category saved sucessfully';

        return response()->json($data, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test()
    {
        dd('asd');
    }
}
