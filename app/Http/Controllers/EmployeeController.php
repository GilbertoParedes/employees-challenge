<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
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
        $validated = $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|email:rfc,dns|unique:employees',
            'job_position' => 'required|max:50',
            'birth_date' =>  'required|date',
            'address' => 'required|max:100',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'job_position' => $request->job_position,
            'birth_date' => Carbon::create( $request->birth_date ),
            'address' => $request->address
        ]);

        $emp = Employee::find($employee->id);

        foreach ($request->skill as $skill) {
            $emp->skills()->attach($skill[0], ['qualify' => $skill[1]]);
        }

        return response()->json($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $sills = $employee->skills()->get();

        return response()->json([$employee, $sills]);
    }

    public function getGeoLocalization($address)
    {
        $response = Http::post('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyBeYP5m8DF8-5UyLmNPdSm9YPRIeM8s_Ts');
        
        return $response->body();
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
        $employee = Employee::find($id);
        $employee->delete();
        
        return response()->json($employee);
    }
}
