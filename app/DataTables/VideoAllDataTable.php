<?php

namespace App\DataTables;

use App\Models\Video;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VideoAllDataTable extends DataTable
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

                return $query->Author->name;
            })
            ->addColumn('Status', function ($query) {

                $yes = $no = '';
                $query->status == 1 ? $yes = 'selected' : $no = 'selected';

                $status = '
                <select class="form-control change_status" data-id="' . $query->id . '">
                    <option value="yes" ' . $yes . '>Yes</option>
                    <option value="no" ' . $no . '>No</option>
                </select>
            ';

                return $status;
            })
            ->addColumn('description', function ($query) {

                $t = trim(substr($query->description, 0, 200)) . '...';

                return $t;
            })
            ->addColumn('video', function ($query) {

                $url = $query->url;
                if (strpos($url, 'www.youtube.com/watch')) {

                    $url = str_replace('watch?v=', 'embed/', $url);
                }

                $video = '
                <iframe width="250"
                src="' . $url . '">
                </iframe>
            ';

                return $video;
            })
            ->rawColumns(['Status', 'description', 'video', 'Author']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Video $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('videoall-table')
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
            Column::make('video'),
            Column::make('description'),
            Column::make('Status')->width(200),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VideoAll_' . date('YmdHis');
    }
}
