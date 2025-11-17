<?php

namespace App\Services\Janitorial;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\JanitorialRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function uploadFiles(array $payload): JanitorialRequest
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
            $path = "janitorial_request_uploads/{$folder}/{$filename}";

            // Upload file to SFTP or configured disk
            $success = Storage::disk($disk)->put($path, file_get_contents($uploadedFile->getRealPath()));
            if (!$success) {
                throw new \Exception('File upload failed for ' . $uploadedFile->getClientOriginalName() . ' ' . $path);
            }
            $this->janitorialRequest->fileable()->create([
                'label' => $file['label'],
                'filename' => $filename,
                'path' => $path,
            ]);
        }
        return $this->janitorialRequest->fresh('fileable');
    }

}
