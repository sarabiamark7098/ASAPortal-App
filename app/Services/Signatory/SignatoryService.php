<?php

namespace App\Services\Signatory;

use App\Models\Signatory;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class SignatoryService implements SignatoryManager
{
    public Model $model;

    private Signatory $signatory;

    public function __construct(Signatory $model)
    {
        $this->model = $model;
    }
    public function search(int $perPage = 20): Paginator
    {
        return $this->model->filtered()->paginate($perPage);
    }


}
