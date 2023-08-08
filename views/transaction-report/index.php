<?php

/**
 * @var \app\models\TransactionReport[] $transactionReports
 */
?>

<script>
function deleteReport(id) {
    event.preventDefault();
    document.getElementById('delete-form-' + id).submit();
}
</script>
<div class="row align-items-center">
    <div class="col-8 offset-2">
        <a href="/transaction-report/create" class="btn btn-primary" style="margin-bottom: 10px;">
            Upload transactions report
        </a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Path</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactionReports as $idx => $transactionReport) : ?>
                <tr>
                    <th scope="row"><?= $idx + 1 ?></th>
                    <td><?= $transactionReport->path ?></td>
                    <td><?= $transactionReport->created_at ?></td>
                    <td>
                        <a href="/chart/generate?transaction_report=<?= $transactionReport->id ?>"
                            class="btn btn-primary">
                            Generate chart
                        </a>
                        <button class="btn btn-danger" onclick="deleteReport(<?= $transactionReport->id ?>)">
                            Delete
                        </button>
                        <form id="delete-form-<?= $transactionReport->id ?>" action="/transaction-report/delete"
                            method="POST" class="d-none">
                            <input type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
                                value="<?= \Yii::$app->request->csrfToken; ?>" />
                            <input type="hidden" name="transactionReport" value="<?= $transactionReport->id ?>">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>