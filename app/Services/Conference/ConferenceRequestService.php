<?php

namespace App\Services\Conference;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\ConferenceRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class ConferenceRequestService implements ConferenceRequestManager
{
    public Model $model;

    private ConferenceRequest $conferenceRequest;

    public function __construct(ConferenceRequest $model)
    {
        $this->model = $model;
    }

     public function setConferenceRequest(ConferenceRequest $conferenceRequest): self
    {
        $this->conferenceRequest = $conferenceRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): ConferenceRequest
    {
        $conferenceRequest = $this->model->create($payload);

        $conferenceRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $conferenceRequest;
    }

    public function update(array $payload): ConferenceRequest
    {
        $this->conferenceRequest->update($payload);
        return $this->conferenceRequest->fresh();
    }

    public function updateStatus(Status $status): ConferenceRequest
    {
        $this->conferenceRequest->status = $status;
        $this->conferenceRequest->save();
        return $this->conferenceRequest->fresh();
    }

    public function addSignatories(array $payload)
    {

        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->conferenceRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }

}
