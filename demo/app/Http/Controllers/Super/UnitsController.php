<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\UnitModel;
use App\Services\UnitService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUnitRequest; // Assumed correct request class for storing units
use App\Http\Requests\UpdateUnitRequest; // Assumed correct request class for updating units

class UnitsController extends Controller
{
    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index(Request $request)
    {
        try {
            $units = UnitModel::query()->paginate(5)->withQueryString();
            $table = $this->unitService->getAllUnitsFormatted(5);
            $title = 'Unidades';
            return view('Back.Units.index', compact('units', 'title', 'table'));
        } catch (\Exception $e) {
            \Log::error("Error loading units index: " . $e->getMessage());
            return redirect()->back()->withErrors('Unable to load units.');
        }
    }


    public function create()
    {
        try {
            $title = 'Create New Unit';
            return view('Back.Units.create', compact('title'));
        } catch (\Exception $e) {
            \Log::error("Error accessing create unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the create unit page.');
        }
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'nullable|max:30',
            'coordinator' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'starttime' => 'nullable|date_format:H:i',
            'endtime' => 'nullable|date_format:H:i',
            'servicetime' => 'nullable|numeric',
            'active' => 'nullable' // Ensure this is not directly validating as boolean
        ]);

        // Manually handle the 'active' field to convert it to 0 or 1
        $validatedData['active'] = $request->has('active') ? 1 : 0;

        UnitModel::create($validatedData);
        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
    }






    public function edit($id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $title = "Edit Unit";
            return view('Back.Units.edit', compact('unit', 'title'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Unit not found: " . $e->getMessage());
            return redirect()->route('units.index')->with('error', "Unit not found.");
        } catch (\Exception $e) {
            \Log::error("Error accessing edit unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the edit unit page.');
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $unit->update($request->validated());
            return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
        } catch (\Exception $e) {
            \Log::error("Error updating unit: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update the unit.');
        }
    }

    public function destroy($id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $unit->delete();
            return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
        } catch (\Exception $e) {
            \Log::error("Error deleting unit: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to delete the unit.');
        }
    }

}
