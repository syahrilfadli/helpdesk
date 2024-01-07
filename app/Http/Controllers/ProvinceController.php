<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {

            $province = Province::where('created_by',\Auth::user()->id)->get();

            return view('admin.province.index',compact('province'));

    }

    public function create()
    {
        $user = \Auth::user();

        return view('admin.province.create');


    }

    public function store(Request $request)
    {
        $user = \Auth::user();

           $validation = [
            'name' => 'required|string|max:255',
          ];
          $province = new Province();
          $province->name = $request->name;
          $province->created_by = \Auth::user()->createId();
          $province->save();

          return redirect()->route('admin.province.index')->with('success', __('Province created successfully'));


    }

    public function edit($id)
    {
        $user = \Auth::user();

            $province = Province::find($id);

            return view('admin.province.edit', compact('province'));


    }

    public function update(Request $request,$id)
    {

        $userObj = \Auth::user();

            $province = Province::find($id);
            $province->name = $request->name;
            $province->save();
            return redirect()->route('admin.province.index')->with('success', __('Province updated successfully'));


    }

    public function destroy($id)
    {

        $user = \Auth::user();

            $province = Province::find($id);
            $province->delete();

            return redirect()->back()->with('success', __('Province deleted successfully'));

    }
}
