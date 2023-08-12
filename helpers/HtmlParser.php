<?php

namespace app\helpers;

use app\dto\Balance;
use DOMDocument;
use DOMElement;

class HtmlParser
{
    private DOMDocument $dom;

    public function __construct(string $html)
    {
        $this->dom = new DOMDocument();
        $this->dom->loadHTML($html);
    }

    public function getBalance(string $balanceColumnName, string $timeColumnName): Balance
    {
        $table = $this->parseTableToArray();

        $balance = new Balance();

        $columnBalanceIdx = false;
        $columnTimeIdx = false;

        foreach ($table as $row) {
            if ($columnBalanceIdx === false || $columnTimeIdx === false) {
                $columnBalanceIdx = $this->getColumnIdxCaseInsensitive($balanceColumnName, $row);
                $columnTimeIdx = $this->getColumnIdxCaseInsensitive($timeColumnName, $row);
                continue;
            }

            if (!isset($row[$columnBalanceIdx], $row[$columnTimeIdx]) || empty($row[$columnTimeIdx])) {
                continue;
            }

            $balance->add(
                $row[$columnTimeIdx],
                $this->getParsedProfit($row[$columnBalanceIdx])
            );
        }

        return $balance;
    }

    /**
     * @param string $columnName column, that will be extract to array
     * 
     * @return array
     */
    public function getColumnValues(string $columnName): array
    {
        $table = $this->parseTableToArray();

        $columnValues = [];

        $columnIdx = false;
        foreach ($table as $row) {
            if ($columnIdx === false) {
                $columnIdx = array_search($columnName, $row);
                continue;
            }

            if (isset($row[$columnIdx])) {
                $columnValues[] = $row[$columnIdx];
            }
        }

        return $columnValues;
    }

    /**
     * @throws \Exception
     */
    public function parseTableToArray(): array
    {
        $table = $this->getFirstTable();
        $rows = $table->getElementsByTagName('tr');

        $parsedRows = [];
        foreach ($rows as $row) {
            $parsedRows[] = $this->getParsedRow($row);
        }

        return $parsedRows;
    }

    /**
     * @throws \Exception
     */
    private function getFirstTable(): DOMElement
    {
        $tables = $this->dom->getElementsByTagName('table');
        $firstTable = $tables->item(0);
        if (is_null($firstTable)) {
            throw new \Exception('There is no tables to parse');
        }

        return $firstTable;
    }

    private function getParsedRow(DOMElement $row): array
    {
        $cells = $row->getElementsByTagName('td');

        $parsedRow = [];
        foreach ($cells as $cell) {
            $parsedRow[] = $cell->nodeValue;

            if ($cell->hasAttribute('colspan')) {
                $this->addSkippedByColspanCells($parsedRow, $cell);
            }
        }

        return $parsedRow;
    }

    /**
     * Adds cells that were removed by the colspan attribute back to the row.
     */
    private function addSkippedByColspanCells(array &$parsedRow, DOMElement $cell): void
    {
        $removedCells = array_fill(0, $cell->getAttribute('colspan') - 1, '');
        $parsedRow = array_merge($parsedRow, $removedCells);
    }

    private function getColumnIdxCaseInsensitive(string $columnName, array &$row): int|string|bool
    {
        return array_search(
            strtolower($columnName),
            array_map('strtolower', $row)
        );
    }

    private function getParsedProfit(string $profit): float
    {
        return (float)str_replace(' ', '', $profit);
    }
}
