<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\VehicleAssignment;
use App\Models\VehicleRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class VehicleRequestService implements VehicleRequestManager
{
    public Model $model;

    public VehicleRequest $vehicleRequest;
    
    public function __construct(VehicleRequest $model)
    {
        $this->model = $model;
    }
    
    public function search(int $perPage = 20) : Paginator {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload) : VehicleRequest {
        $vehicleRequest = $this->model->create($payload);

        $vehicleRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $vehicleRequest;
    }

    public function process(VehicleRequest $vehicleRequest, VehicleAssignment $vehicleAssignment) : VehicleRequest {
        $vehicleRequest->vehicleAssignment()->associate($vehicleAssignment);
        $vehicleRequest->status = Status::PROCESSED;
        $vehicleRequest->save();
        return $vehicleRequest->fresh();
    }

    public function addSignatories(VehicleRequest $vehicleRequest, array $payload) {

        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $vehicleRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }
}
