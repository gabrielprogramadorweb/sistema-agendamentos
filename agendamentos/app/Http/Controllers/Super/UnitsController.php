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
    protected $serviceTimes = [
        '10 minutes' => '10 minutos',
        '15 minutes' => '15 minutos',
        '30 minutes' => '30 minutos',
        '1 hour'     => '1 hora',
        '2 hours'    => '2 horas',
    ];
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

    private function validateUnit(Request $request)
    {
        return $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'nullable|max:30',
            'coordinator' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'starttime' => 'nullable|date_format:H:i',
            'endtime' => 'nullable|date_format:H:i',
            'servicetime' => 'nullable|string',
            'active' => 'nullable|boolean'
        ]);
    }

    public function create()
    {
        try {

            $title = 'Create New Unit';
            $serviceTimes = $this->serviceTimes;
            return view('Back.Units.create', compact('title', 'serviceTimes'));
        } catch (\Exception $e) {
            \Log::error("Error accessing create unit page: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to access the create unit page.');
        }
    }


    public function store(Request $request)
    {
        $validatedData = $this->validateUnit($request);
        $validatedData['active'] = $request->has('active') ? 1 : 0;

        UnitModel::create($validatedData);
        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
    }


// In your Controller


    public function edit($id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $title = "Edit Unit";
            $serviceTimes = $this->serviceTimes;
            return view('Back.Units.edit', compact('unit', 'title', 'serviceTimes'));
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
            $validatedData = $this->validateUnit($request);
            $unit->update($validatedData);
            return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
        } catch (\Exception $e) {
            \Log::error("Error updating unit: " . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update the unit:' . $e->getMessage());
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
