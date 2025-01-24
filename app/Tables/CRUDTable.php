<?php

namespace App\Tables;

use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class CRUDTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        $table = (new Table())->model($this->model)
            ->routes($this->routes)
            ->destroyConfirmationHtmlAttributes(fn($item) => [
                'data-confirm' => __($this->confirm)
            ])
            ->containerClasses(['card'])
            ->tableClasses(['table','card-table','table-vcenter']);

        return $this->tableAdv($table);
    }

    public function tableAdv($table){
        return $table;
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        //
    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
