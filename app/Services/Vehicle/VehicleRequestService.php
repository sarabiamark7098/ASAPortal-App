<?php

namespace App\Services\Vehicle;

use App\Enums\Status;
use App\Http\Requests\VehicleRequest as RequestsVehicleRequest;
use App\Models\Signatory;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleRequestService implements VehicleRequestManager
{
    public Model $model;

    private VehicleRequest $vehicleRequest;

    public function __construct(VehicleRequest $model)
    {
        $this->model = $model;
    }

    public function setVehicleRequest(VehicleRequest $vehicleRequest): self
    {
        $this->vehicleRequest = $vehicleRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): VehicleRequest
    {
        $vehicleRequest = $this->model->create($payload);

        $vehicleRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $vehicleRequest;
    }

    public function update(array $payload): VehicleRequest
    {
        $this->vehicleRequest->update($payload);
        return $this->vehicleRequest->fresh();
    }

    public function assignVehicle(VehicleAssignment $vehicleAssignment): VehicleRequest
    {
        $this->vehicleRequest->vehicleAssignment()->associate($vehicleAssignment);
        $this->vehicleRequest->save();
        return $this->vehicleRequest->fresh();
    }

    public function updateStatus(Status $status): VehicleRequest
    {
        $this->vehicleRequest->status = $status;
        $this->vehicleRequest->save();
        return $this->vehicleRequest->fresh();
    }

    public function addSignatories(array $payload)
    {
        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->vehicleRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }

    public function uploadFiles(array $payload): VehicleRequest
    {
        foreach ($payload as $file) {
            // Use the helper function to upload the file
            $uploaded = upload_file($file['file'], 'vehicle_request_uploads');

            // Attach the uploaded file to the polymorphic relation
            $this->vehicleRequest->fileable()->create([
                'label' => $file['label'],
                'filename' => $uploaded['filename'],
                'path' => $uploaded['path'],
            ]);
        }
        return $this->vehicleRequest->fresh('fileable');
    }

}
