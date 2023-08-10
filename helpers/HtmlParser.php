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
                $columnBalanceIdx = array_search($balanceColumnName, $row);
                $columnTimeIdx = array_search($timeColumnName, $row);
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
        $cols = $row->getElementsByTagName('td');

        $parsedRow = [];
        foreach ($cols as $col) {
            $parsedRow[] = $col->nodeValue;

            if ($col->hasAttribute('colspan')) {
                $this->addSkipedByColspanCells($parsedRow, $col);
            }
        }

        return $parsedRow;
    }

    private function addSkipedByColspanCells(array &$parsedRow, DOMElement $col): void
    {
        $emptyCells = array_fill(0, $col->getAttribute('colspan') - 1, '');
        $parsedRow = array_merge($parsedRow, $emptyCells);
    }

    private function getParsedProfit(string $profit): float
    {
        return (float)str_replace(' ', '', $profit);
    }
}
