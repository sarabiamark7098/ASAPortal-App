<?php

namespace App\Services\AirTransport;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\AirTransportRequest;
use App\Services\AirTransport\AirTransportRequestManager;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class AirTransportRequestService implements AirTransportRequestManager
{
    public Model $model;

    private AirTransportRequest $airTransportRequest;

    public function __construct(AirTransportRequest $model)
    {
        $this->model = $model;
    }

    public function setAirTransportRequest(AirTransportRequest $airTransportRequest): self
    {
        $this->airTransportRequest = $airTransportRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): AirTransportRequest
    {
        $airTransportRequest = $this->model->create($payload);

        $airTransportRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $airTransportRequest;
    }

    public function update(array $payload): AirTransportRequest
    {
        $this->airTransportRequest->update($payload);
        return $this->airTransportRequest->fresh();
    }

    public function updateStatus(Status $status): AirTransportRequest
    {
        $this->airTransportRequest->status = $status;
        $this->airTransportRequest->save();
        return $this->airTransportRequest->fresh();
    }
    public function addPassengers(array $payload)
    {
        foreach ($payload as $passenger) {
            $this->airTransportRequest->passengers()->create([
                'first_name' => $passenger['first_name'],
                'last_name' => $passenger['last_name'],
                'birth_date' => $passenger['birth_date'],
                'position' => $passenger['position'],
                'email' => $passenger['email'],
                'contact_number' => $passenger['contact_number'],
            ]);
        }
    }
    public function addFlights(array $payload)
    {
        foreach ($payload as $flight) {
            $this->airTransportRequest->flights()->create([
                'destination_from' => $flight['destination_from'],
                'destination_to' => $flight['destination_to'],
                'trip_mode' => $flight['trip_mode'],
                'departure_date' => $flight['departure_date'],
                'etd' => $flight['etd'],
                'eta' => $flight['eta'],

            ]);
        }
    }

    public function addSignatories(array $payload)
    {

        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->airTransportRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }

}
