<?php

namespace App\Services\Assistance;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\AssistanceRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssistanceRequestService implements AssistanceRequestManager
{
    public Model $model;

    private AssistanceRequest $assistanceRequest;

    public function __construct(AssistanceRequest $model)
    {
        $this->model = $model;
    }

    public function setAssistanceRequest(AssistanceRequest $assistanceRequest): self
    {
        $this->assistanceRequest = $assistanceRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): AssistanceRequest
    {
        $assistanceRequest = $this->model->create($payload);

        $assistanceRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $assistanceRequest;
    }

    public function update(array $payload): AssistanceRequest
    {
        $this->assistanceRequest->update($payload);
        return $this->assistanceRequest->fresh();
    }

    public function updateStatus(Status $status): AssistanceRequest
    {
        $this->assistanceRequest->status = $status;
        $this->assistanceRequest->save();
        return $this->assistanceRequest->fresh();
    }

    public function addSignatories(array $payload)
    {

        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->assistanceRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }

    public function uploadFiles(array $payload): AssistanceRequest
    {
        foreach ($payload as $file) {
            // Use the helper function to upload the file
            $uploaded = upload_file($file['file'], 'assistance_request_uploads');

            // Attach the uploaded file to the polymorphic relation
            $this->assistanceRequest->fileable()->create([
                'label' => $file['label'],
                'filename' => $uploaded['filename'],
                'path' => $uploaded['path'],
            ]);
        }

    // Return fresh instance with loaded relation
    return $this->assistanceRequest->fresh('fileable');
    }

}
