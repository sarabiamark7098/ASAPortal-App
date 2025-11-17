<?php

namespace App\Services\Conference;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\ConferenceRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function uploadFiles(array $payload): ConferenceRequest
    {
        foreach ($payload as $file) {
            $disk = config('filesystems.default', 'local');
            $uploadedFile = $file['file'];
            $extension = $uploadedFile->getClientOriginalExtension() ?? 'bin';
            $datePart = Carbon::now()->format('Ymd-His');
            $randomPart = Str::random(6);
            $filename = "{$datePart}-{$randomPart}.{$extension}";

            // Optional: folder by date for better organization
            $folder = Carbon::now()->format('Y-m-d');
            $path = "conference_request_uploads/{$folder}/{$filename}";

            // Upload file to SFTP or configured disk
            $success = Storage::disk($disk)->put($path, file_get_contents($uploadedFile->getRealPath()));
            if (!$success) {
                throw new \Exception('File upload failed for ' . $uploadedFile->getClientOriginalName() . ' ' . $path);
            }
            $this->conferenceRequest->fileable()->create([
                'label' => $file['label'],
                'filename' => $filename,
                'path' => $path,
            ]);
        }
        return $this->conferenceRequest->fresh('fileable');
    }

}
