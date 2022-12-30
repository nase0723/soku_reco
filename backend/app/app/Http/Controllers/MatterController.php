<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMatterRequest;
use App\Http\Requests\UpdateMatterRequest;
use Illuminate\Http\Request;
use App\Models\Matter;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MatterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $matters = Matter::where('user_id', Auth::id())->orderBy($request->column, $request->type)->limit(100)->get();
        return response()->json(['status' => true, 'matters' => $matters], 200);
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
     * @param  \App\Http\Requests\StoreMatterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMatterRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $created = Matter::create($data);
        return response()->json(['status' => true, 'matter' => $created], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matter = Matter::find($id);
        return response()->json(['status' => true, 'matter' => $matter], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function edit(Matter $matter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMatterRequest  $request
     * @param  \App\Models\Matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMatterRequest $request, $id)
    {
        Matter::find($id)->update($request->all());
        return response()->json(['status' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Matter::destroy($id);
        return response()->json(['status' => true], 200);
    }
}
