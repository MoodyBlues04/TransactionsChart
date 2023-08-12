<?php

namespace app\repository;

use app\models\TransactionReport;

class TransactionReportRepository
{
    /**
     * @throws \Exception
     */
    public function getByIdOrFail(int $id): TransactionReport
    {
        $transactionReport = $this->getById($id);
        if (is_null($transactionReport)) {
            throw new \Exception("Report not found by id: {$id}");
        }
        return $transactionReport;
    }

    public function getById(int $id): ?TransactionReport
    {
        return TransactionReport::findOne($id);
    }

    public function getAllOrdered(): array
    {
        return TransactionReport::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }
}
