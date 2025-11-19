<?php

namespace App\Services\Janitorial;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\JanitorialRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class JanitorialRequestService implements JanitorialRequestManager
{
    public Model $model;

    private JanitorialRequest $janitorialRequest;

    public function __construct(JanitorialRequest $model)
    {
        $this->model = $model;
    }

    public function setJanitorialRequest(JanitorialRequest $janitorialRequest): self
    {
        $this->janitorialRequest = $janitorialRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): JanitorialRequest
    {
        $janitorialRequest = $this->model->create($payload);

        $janitorialRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $janitorialRequest;
    }

    public function update(array $payload): JanitorialRequest
    {
        $this->janitorialRequest->update($payload);
        return $this->janitorialRequest->fresh();
    }

    public function updateStatus(Status $status): JanitorialRequest
    {
        $this->janitorialRequest->status = $status;
        $this->janitorialRequest->save();
        return $this->janitorialRequest->fresh();
    }

    public function addSignatories(array $payload)
    {
        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->janitorialRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }
    public function addJanitors(array $payload)
    {
        foreach ($payload as $janitor) {
            $this->janitorialRequest->janitorable()->create([
                'full_name' => $janitor['full_name'],
            ]);
        }
    }
}
