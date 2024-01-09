<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_admin', 1)->get();
        return view('admin.teacher.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::all();
        return view('admin.teacher.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validators = Validator::make($request->all(), [
            'photo' => 'image|mimes:png,jpg,jpeg,gif',
            'major_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
        ]);

        if($validators->fails()){
            return redirect()->back();
        }

        $image = $request->file('photo');
        $image->storeAs('public/users', $image->hashName());

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $image->hashName(),
            'is_admin' => 1,
            'major_id' => $request->major_id,
        ]);

        return redirect()->route('admin.teacher.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back();
    }
}
