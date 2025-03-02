<?php

namespace App\DataTables;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NewsAllDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('Author', function ($query) {

                return $query->author->name;
            })
            ->addColumn('Is Comment', function ($query) {

                $yes = $no = '';
                $query->is_comment == 1 ? $yes = 'selected' : $no = 'selected';

                $share = '
                <select class="form-control change_comment" data-id="' . $query->id . '">
                    <option value="yes" ' . $yes . '>Yes</option>
                    <option value="no" ' . $no . '>No</option>
                </select>
            ';

                return $share;
            })
            ->addColumn('Status', function ($query) {

                $yes = $no = '';
                $query->status == 1 ? $yes = 'selected' : $no = 'selected';

                $share = '
                <select class="form-control change_status" data-id="' . $query->id . '">
                    <option value="yes" ' . $yes . '>Yes</option>
                    <option value="no" ' . $no . '>No</option>
                </select>
            ';

                return $share;
            })
            ->addColumn('Post Image', function ($query) {

                $img = '<img src="' . asset($query->PostImage[0]->image) . '" width="150px"/>';

                return $img;
            })
            ->rawColumns(['Is Comment', 'Status', 'Post Image', 'Author']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(News $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('newsall-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('Author')->width(100),
            Column::make('Post Image'),
            Column::make('title'),
            Column::make('Is Comment')->width(200),
            Column::make('Status')->width(200),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'NewsAll_' . date('YmdHis');
    }
}
