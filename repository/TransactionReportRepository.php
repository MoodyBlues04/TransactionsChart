<?php

namespace app\repository;

use app\models\TransactionReport;

class TransactionReportRepository
{
    public function getById(int $id): ?TransactionReport
    {
        return TransactionReport::findOne($id);
    }
}
