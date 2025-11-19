<?php

namespace App\Services\Entry;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\EntryRequest;
use App\Services\Entry\EntryRequestManager;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EntryRequestService implements EntryRequestManager
{
    public Model $model;

    private EntryRequest $entryRequest;

    public function __construct(EntryRequest $model)
    {
        $this->model = $model;
    }

    public function setEntryRequest(EntryRequest $entryRequest): self
    {
        $this->entryRequest = $entryRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): EntryRequest
    {
        $entryRequest = $this->model->create($payload);

        $entryRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $entryRequest;
    }

    public function update(array $payload): EntryRequest
    {
        $this->entryRequest->update($payload);
        return $this->entryRequest->fresh();
    }

    public function updateStatus(Status $status): EntryRequest
    {
        $this->entryRequest->status = $status;
        $this->entryRequest->save();
        return $this->entryRequest->fresh();
    }
    public function addGuests(array $payload)
    {
        foreach ($payload as $guest) {
            $this->entryRequest->guests()->create([
                'full_name' => $guest['full_name'],
                'purpose' => $guest['purpose'],
            ]);
        }
    }

    public function addSignatories(array $payload)
    {

        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->entryRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }

    public function uploadFiles(array $payload): EntryRequest
    {
        foreach ($payload as $file) {
            // Use the helper function to upload the file
            $uploaded = upload_file($file['file'], 'entry_request_uploads');

            // Attach the uploaded file to the polymorphic relation
            $this->entryRequest->fileable()->create([
                'label' => $file['label'],
                'filename' => $uploaded['filename'],
                'path' => $uploaded['path'],
            ]);
        }
        return $this->entryRequest->fresh('fileable');
    }

}
