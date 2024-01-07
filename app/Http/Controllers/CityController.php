<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $user = \Auth::user();
        if($user->can('manage-city'))
        {

            $cities = City::with(['users'])->where('created_by',\Auth::user()->createId())->get();


            return view('admin.city.index', compact('cities'));
        }
        else
        {
            return view('403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        $users = User::where('parent',\Auth::user()->createId())->get()->pluck('name','id');
        $users->users  = explode(',', $user->users);
        if($user->can('create-city'))
        {

            return view('admin.city.create',compact('users'));

        }
        else
        {
            return view('403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        if($user->can('create-city'))
        {
            $validation = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'province_id' => [
                    'required',
                    'integer',
                ],
            ];
            $request->validate($validation);



            $city = new City();
            $city->name = $request->name;
            $city->created_by = \Auth::user()->createId();
            $city->province_id = $request->province_id;
            $city->save();


            return redirect()->route('admin.city')->with('success', __('City created successfully'));
        }
        else
        {
            return view('403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
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
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userObj = \Auth::user();
        $city = City::find($id);
        $users = User::where('parent',\Auth::user()->createId())->get()->pluck('name','id');
        $users->prepend(__('Select User'), '');
        $users->users  = explode(',', $userObj->users);
        $userObj->cities  = explode(',', $userObj->cities);

        if($userObj->can('edit-city'))
        {
            $city = City::find($id);

            return view('admin.city.edit', compact('city','users','catgoryuser'));
        }
        else
        {
            return view('403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {


        $userObj = \Auth::user();
        if($userObj->can('edit-city'))
        {
            $city        = City::find($id);

            $city->name  = $request->name;
            $city->color = $request->color;
            if(!empty($request->users)){
                UserCatgory::where('city_id',$city->id)->delete();
                foreach($request->users as $value)
                {
                    $usercity = UserCatgory::create([
                    'user_id' => $value,
                    'city_id' => $city->id,
                    ]);
                }
            }
            $city->save();

            return redirect()->route('admin.city')->with('success', __('City updated successfully'));
        }
        else
        {
            return view('403');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \Auth::user();
        if($user->can('delete-city'))
        {
            $city = City::find($id);
            $city->delete();

            return redirect()->route('admin.city')->with('success', __('City deleted successfully'));
        }
        else
        {
            return view('403');
        }
    }

}
