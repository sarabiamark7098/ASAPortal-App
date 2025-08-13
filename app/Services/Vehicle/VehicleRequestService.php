<?php

namespace App\Services\Vehicle;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

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
}
