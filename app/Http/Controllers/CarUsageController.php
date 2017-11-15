<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CarUsage;
use App\Models\CarStatus;
use App\Models\HistoryCarUsage;
use App\Support\CarUsageMisc;

class CarUsageController extends Controller
{
    use CarUsageMisc;

    public function index()
    {
        $car_usages = CarUsage::orderBy('updated_at', 'desc')->paginate(20);
        return view('car-usage.index', compact('car_usages'));
    }

    public function historyIndex()
    {
        $mode = 'all';
        $car_usages = HistoryCarUsage::orderBy('end_use', 'desc')->get();
        return view('car-usage.history', compact('car_usages', 'mode'));
    }

    public function create()
    {
        $meta = 'Create';
        $id = null;
        return view('car-usage.form', compact('meta', 'id'));
    }

    public function store(Request $request)
    {
        // Validate
        $data = $request->validate([
            'nip' => 'required',
            'car_plat_number' => 'required',
            'driver_id' => 'required',
            'backup_driver_id' => 'nullable',
            'destination' => 'required',
            'total_passengers' => 'nullable',
            'necessity' => 'nullable',
            'desire_time' => 'nullable',
            'estimates_time' => 'nullable',
            'fuel_status' => 'required',
            'fuel_usage' => 'required|min:0',
            'additional_description' => 'nullable'
        ]);
        $driver = \App\Models\Driver::findOrFail($request->driver_id);

        // When original driver isn't standby and no backup driver selected
        if ($driver->status > 0 && (is_null($request->backup_driver_id) || empty($request->backup_driver_id))) {
            return response()
                ->json([
                    'valid' => false,
                    'message' => 'Driver pengganti harus dipilih apabila driver utama sedang tugas, sakit, izin atau tidak ada informasi'
                ]);
        }

        // Store
        $usage = CarUsage::create($data);

        // Set Driver status (whether it Backup or Original)
        $driver_id = (!is_null($request->backup_driver_id)) ? $request->backup_driver_id : $request->driver_id;
        CarUsageMisc::setStatus($driver_id, "Driver", 1);

        // Set Car status (the original one)
        CarUsageMisc::setStatus($request->car_plat_number, "CarStatus", 1);

        if ($usage) {
            return response()
                ->json([
                    'valid' => true,
                    'message' => 'Berhasil membuat permohonan',
                    'redirect_url' => "/car-usage/{$usage->id}"
                ]);
        }
    }

    // Recap into history
    public function historyStore(Request $request)
    {
        $history = new HistoryCarUsage($request->except(['id', 'nip', 'driver_id', 'backup_driver_id', 'car_plat_number', 'created_at', 'updated_at']));
        $driver = \App\Models\Driver::findOrFail($request->driver_id);

        $history->usage_id = $request->id;
        $history->original_created_date = $request->created_at;
        $history->original_updated_date = $request->updated_at;

        if ($history->save()) {
            // Remove the entity on current usage
            $current_usage = CarUsage::destroy($request->id);

            // Set all relationships status to Standby
            if ($driver_id == 1)
                $this->setStatus("\App\Models\Driver", $request->driver_id, 0);
            if (!is_null($request->backup_driver_id))
                $this->setStatus("\App\Models\Driver", $request->backup_driver_id, 0);

            $this->setStatus("\App\Models\CarStatus", $request->car_plat_number, 0);

            return response()
                ->json([
                    'message' => 'Pemakaian kendaraan telah selesai!',
                    'redirect_url' => '/car-usage/history/' . $request->id
                ]);
        }
    }

    public function show($id)
    {
        $usage = CarUsage::findOrFail($id);
        return view('car-usage.show', compact('usage'));
    }

    public function apiShow($id)
    {
        // Init
        $usage = CarUsage::findOrFail($id);

        // Modify
        $usage->employee_nip      = $usage->nip;
        $usage->employee_name     = $usage->requestedBy->employee_name;
        $usage->employee_position = $usage->requestedBy->employee_position;
        $usage->employee_division = $usage->requestedBy->division;
        $usage->car               = $usage->car_plat_number . " (".$usage->carStatus->theCar->car_name.")";
        $usage->driver            = $usage->drivenBy->driver_name;
        $usage->driver_company    = $usage->drivenBy->workOn->company_name;
        $usage->company_director  = $usage->drivenBy->workOn->company_director;

        $usage->backup_driver           = (!is_null($usage->backup_driver_id)) ? $usage->backupDrivenBy->driver_name : "-";
        $usage->backup_driver_company   = (!is_null($usage->backup_driver_id)) ? $usage->backupDrivenBy->workOn->company_name : "-";
        $usage->backup_company_director = (!is_null($usage->backup_driver_id)) ? $usage->backupDrivenBy->workOn->company_director : "-";

        return response()
            ->json([
                'model' => $usage->makeHidden(['requestedBy', 'drivenBy', 'backupDrivenBy', 'carStatus'])->toArray()
            ]);
    }

    public function historyShow($id)
    {
        $usage = HistoryCarUsage::where('usage_id', $id)->get();
        $usage = $usage[0];
        return view('car-usage.history-show', compact('usage'));
    }

    public function edit($id)
    {
        $meta = 'Edit';
        return view('car-usage.form', compact('meta', 'id'));
    }

    public function update(Request $request, $id)
    {
        // Init
        $usage = CarUsage::findOrFail($id);
        $driver = \App\Models\Driver::findOrFail($usage->driver_id);

        // When original driver isn't standby and no backup driver selected
        if ($driver->status > 1 && (is_null($request->backup_driver_id) || empty($request->backup_driver_id))) {
            return response()
                ->json([
                    'valid' => false,
                    'message' => 'Driver pengganti harus dipilih apabila driver utama sedang tugas, sakit, izin atau tidak ada informasi'
                ]);
        }

        // Behavior between main driver & backup driver
        if (!is_null($usage->backup_driver_id)) {
            // Backup driver is exist from the first time
            if (is_null($request->backup_driver_id) || empty($request->backup_driver_id)) {
                /**
                 *  the backup driver removed
                 *  then the original driver should be work
                 */
                if ($driver->status == 0) $this->setStatus("\App\Models\Driver", $usage->driver_id, 1);
                $this->setStatus("\App\Models\Driver", $usage->backup_driver_id, 0);
            }
            else if ($usage->backup_driver_id != $request->backup_driver_id) {
                /**
                 *  the backup driver changed to another backup driver
                 *  then the the old backup driver should be standby / removed
                 */
                $this->setStatus("\App\Models\Driver", $usage->backup_driver_id, 0);
                $this->setStatus("\App\Models\Driver", $request->backup_driver_id, 1);
            }
        }
        else {
            // If first time there's no backup driver and want to change it to backup driver
            if (!is_null($request->backup_driver_id)) {
                $this->setStatus("\App\Models\Driver", $request->backup_driver_id, 1);
                // The main driver should be back to standby
                if($driver->status == 1) {
                    $this->setStatus("\App\Models\Driver", $request->driver_id, 0);
                }
            }
        }

        if ($usage->car_plat_number != $request->car_plat_number) {
            $this->setStatus("\App\Models\CarStatus", $usage->car_plat_number, 0);
        }

        $usage->fill($request->except([
            "employee_nip",
            "employee_name",
            "employee_position",
            "employee_division",
            "driver",
            "backup_driver",
            "driver_company",
            "backup_driver_company",
            "company_director",
            "backup_company_director",
            "car",
            "created_at",
            "updated_at",
            "_method"
        ]));

        // Update        
        if ($usage->save()) {
            Log::info("Record penggunaan kendaraan #{$id} diubah");
            return response()
                ->json([
                    'valid' => true,
                    'message' => 'Data permohonan / pemakaian kendaraan berhasil diupdate!',
                    'redirect_url' => '/car-usage'
                ]);
        }
    }

    private function setStatus($model_name, $primary_key, $status)
    {
        $entity = $model_name::findOrFail($primary_key);
        $entity->status = $status;
        $entity->save();
    }

    public function destroy($id)
    {
        // Init
        $usage = CarUsage::findOrFail($id);
        $data = array(
            'message' => "Data permohonan / pemakaian kendaraan berhasil dihapus!",
            'redirect_url' => "/car-usage"
        );

        $driver_id = (!is_null($usage->backup_driver_id)) ? $usage->backup_driver_id : $usage->driver_id;

        // Destroy
        if ($usage->delete()) {
            // Setback Driver status
            CarUsageMisc::setStatus($usage->backup_driver_id, "Driver", 0);

            // Setback Car status
            CarUsageMisc::setStatus($usage->car_plat_number, "CarStatus", 0);

            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }

    public function historyDestroy($id)
    {
        // Init
        $history = HistoryCarUsage::where('usage_id', $id)->delete();
        $data = array(
            'message' => "Data pemakaian kendaraan berhasil dihapus!",
            'redirect_url' => "/car-usage/history/all"
        );

        if ($history) {
            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }
}
