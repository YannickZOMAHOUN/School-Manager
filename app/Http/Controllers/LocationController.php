<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Department;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('locations.index', compact('countries'));
    }

    public function storeCountry(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Country::create($request->all());
        return redirect()->back()->with('success', 'Pays créé avec succès.');
    }

    public function storeDepartment(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'country_id' => 'required|exists:countries,id']);
        Department::create($request->all());
        return redirect()->back()->with('success', 'Département créé avec succès.');
    }

    public function storeCity(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'department_id' => 'required|exists:departments,id']);
        City::create($request->all());
        return redirect()->back()->with('success', 'Commune créée avec succès.');
    }

      public function getDepartments($countryId)
    {
        $departments = Department::where('country_id', $countryId)->get();
        return response()->json($departments);
    }

    public function getCities($departmentId)
    {
        $cities = City::where('department_id', $departmentId)->get();
        return response()->json($cities);
    }
}
