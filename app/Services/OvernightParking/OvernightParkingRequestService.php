<?php

namespace App\Services\OvernightParking;

use App\Enums\Status;
use App\Models\Signatory;
use App\Models\OvernightParkingRequest;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OvernightParkingRequestService implements OvernightParkingRequestManager
{
    public Model $model;

    private OvernightParkingRequest $overnightParkingRequest;

    public function __construct(OvernightParkingRequest $model)
    {
        $this->model = $model;
    }

    public function setOvernightParkingRequest(OvernightParkingRequest $overnightParkingRequest): self
    {
        $this->overnightParkingRequest = $overnightParkingRequest;
        return $this;
    }

    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }

    public function create(array $payload): OvernightParkingRequest
    {
        $overnightParkingRequest = $this->model->create($payload);

        $overnightParkingRequest->transactable()->create([
            'user_id' => $payload['user_id'],
        ]);

        return $overnightParkingRequest;
    }

    public function update(array $payload): OvernightParkingRequest
    {
        $this->overnightParkingRequest->update($payload);
        return $this->overnightParkingRequest->fresh();
    }

    public function updateStatus(Status $status): OvernightParkingRequest
    {
        $this->overnightParkingRequest->status = $status;
        $this->overnightParkingRequest->save();
        return $this->overnightParkingRequest->fresh();
    }

    public function addSignatories(array $payload)
    {

        foreach ($payload as $signee) {
            $signatory = Signatory::find($signee['id']);

            $this->overnightParkingRequest->signable()->create([
                'label' => $signee['label'],
                'full_name' => $signatory->full_name,
                'position' => $signatory->position,
            ]);
        }
    }

    public function uploadFiles(array $payload): OvernightParkingRequest
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
            $path = "overnight_parking_request_uploads/{$folder}/{$filename}";

            // Upload file to SFTP or configured disk
            $success = Storage::disk($disk)->put($path, file_get_contents($uploadedFile->getRealPath()));
            if (!$success) {
                throw new \Exception('File upload failed for ' . $uploadedFile->getClientOriginalName() . ' ' . $path);
            }
            $this->overnightParkingRequest->fileable()->create([
                'label' => $file['label'],
                'filename' => $filename,
                'path' => $path,
            ]);
        }
        return $this->overnightParkingRequest->fresh('fileable');
    }

}
