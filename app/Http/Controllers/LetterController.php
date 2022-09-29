<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Letter;
use App\Models\Department;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use App\Http\Resources\UserLetterHelperResource;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      
        $letters = Letter::with('user', 'user.department')->paginate(10);
        $departments = Department::all()->pluck('name', 'id');
        $letterTypes = LetterType::all()->pluck('name', 'id');
        $users = User::all();
        
        $usersModified = array();
        foreach($users as  $user){
            $usersModified[$user->id] = $user->npk . ' - ' . $user->name;
        }

        return view('letters.index',compact('usersModified', 'letters', 'departments', 'letterTypes'));
    }

    // handle upload file

    public function handleUploadFile($request)
    {
        $user = User::find($request->npk);
        $user->load('department');
        
        $letterType = LetterType::find($request->id);

        $file = $request->file('file');
        $name = hexdec(uniqid()) . $user->name . '-' . $user->department->name .'-' . $letterType->name . '.' . $file->getClientOriginalExtension();
        $filePath = 'uploads/letters/' . $user->department->slug . '/' . Carbon::now()->format('d-m-Y') . '/';
        $file->move(public_path($filePath), $name); // file directory
        $path = $filePath . $name;

        return $path;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $this->validate($request, [
            'npk' => 'required',
            'name' => 'required',
            'letter_type_id' => 'required',
            'department_id' => 'required',
            'file' => 'required|mimes:pdf|max:10240',
            'date' => 'required',
        ]);

        if (request()->hasFile('file')) {
            $path = $this->handleUploadFile($request);
            $payload['file_path'] = $path;
        }

        $payload['user_id'] = $request->user()->id;
        Letter::create($payload);
    
        return redirect()->route('letters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activeDepartment = Department::findOrFail($id);
        $usersInDepartment = User::where('department_id', $id)->paginate(10);
        $departments = Department::where('id', '!=', $id)->pluck('name', 'id')->all();

        return view('departments.show', compact('usersInDepartment', 'departments', 'activeDepartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $letter = Letter::find($id);
    
        return view('letters.edit',compact('letterType'));
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
        $payload = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
    
        $letter = Letter::find($id);
        $letter->update($payload);
        
        return redirect()->route('letters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Letter::find($id)->delete();
        return redirect()->route('letters.index');
    }
}