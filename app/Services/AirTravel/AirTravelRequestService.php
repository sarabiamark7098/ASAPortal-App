<?php

namespace App\Services\Assistance;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\AirTravelRequest;
use App\Services\AirTravel\AirTravelRequestManager;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class AirTravelRequestService implements AirTravelRequestManager
{
    public Model $model;

    private AirTravelRequest $airTravelRequest;

    public function __construct(AirTravelRequest $model)
    {
        $this->model = $model;
    }

    public function setAirTravelRequest(AirTravelRequest $airTravelRequest): self
    {
        $this->airTravelRequest = $airTravelRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): AirTravelRequest
    {
        $airTravelRequest = $this->model->create($payload);

        $airTravelRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $airTravelRequest;
    }

    public function update(array $payload): AirTravelRequest
    {
        $this->airTravelRequest->update($payload);
        return $this->airTravelRequest->fresh();
    }

    public function updateStatus(Status $status): AirTravelRequest
    {
        $this->airTravelRequest->status = $status;
        $this->airTravelRequest->save();
        return $this->airTravelRequest->fresh();
    }
    public function addPassengers(array $payload)
    {
        foreach ($payload as $passenger) {
            $this->airTravelRequest->passenger()->create([
                'first_name' => $passenger->first_name,
                'last_name' => $passenger->last_name,
                'birth_date' => $passenger->birth_date,
                'position' => $passenger->position,
                'email' => $passenger->email,
                'contact_number' => $passenger->contact_number,
            ]);
        }
    }
    public function addFlights(array $payload)
    {
        foreach ($payload as $flight) {
            $this->airTravelRequest->flight()->create([
                'destination' => $flight->destination,
                'date_departure' => $flight->date_departure,
                'departure_etd' => $flight->departure_etd,
                'departure_eta' => $flight->departure_eta,
                'date_arrival' => $flight->date_arrival,
                'arrival_etd' => $flight->arrival_etd,
                'arrival_eta' => $flight->arrival_eta,
            ]);
        }
    }

    public function addSignatories(array $payload)
    {

        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->airTravelRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }

}
