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
        $units = UnitModel::query()->paginate(5)->withQueryString();
        $table = $this->unitService->getAllUnitsFormatted(5);
        $title = 'Unidades';
        return view('Back.Units.index', compact('units', 'title', 'table'));
    }

    public function create()
    {
        return view('Back.Units.create');
    }

    public function store(StoreUnitRequest $request)
    {
        $unit = UnitModel::create($request->validated());
        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
    }

    public function edit($id)
    {
        try {
            $unit = UnitModel::findOrFail($id);
            $title = "Edit Unit";  // Define the title for this view
            return view('Back.Units.edit', compact('unit', 'title'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('units.index')->with('error', "Registro {$id} não encontrado.");
        }
    }


    public function update(Request $request, $id)
    {
        $unit = UnitModel::findOrFail($id);

        // Validate all necessary fields
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:30',
            'coordinator' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'services' => 'nullable|array',
            'starttime' => 'nullable|date_format:H:i',
            'endtime' => 'nullable|date_format:H:i',
            'servicetime' => 'nullable|numeric',
            'active' => 'nullable|boolean'
        ]);

        $unit->update($validated);

        return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
    }



    public function destroy($id)
    {
        $unit = UnitModel::findOrFail($id);
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }

    // Note: Removed methods that handled `Home` since they seemed incorrectly placed.
}
