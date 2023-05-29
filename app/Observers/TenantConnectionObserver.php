<?php

namespace App\Observers;

use Hyn\Tenancy\Traits\UsesTenantConnection;

class TenantConnectionObserver
{
    protected $exceptModels = [
        // Daftar model yang akan dikecualikan (gunakan nama kelas model)
        // \App\Models\ExampleModel::class,
        // \App\Models\AnotherModel::class,
    ];

    public function retrieved($model)
    {
        if (!in_array(get_class($model), $this->exceptModels)) {
            $model->setConnection(config('tenancy.db.tenant-connection-name'));
        }
    }
}
