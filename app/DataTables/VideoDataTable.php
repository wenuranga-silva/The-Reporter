<?php

namespace App\DataTables;

use App\Models\Video;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VideoDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {

                $btn = '
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-cogs"></i>
                </button>
                <div class="dropdown-menu">

                    <div style="display:flex;justify-content:space-around">
                        <a href="' . route('admin.video.edit', $query->id) . '" class="btn btn-sm btn-primary mx-1"><i class="fas fa-pencil-alt"></i></a>
                        <a href="' . route('admin.video.destroy', $query->id) . '" class="btn btn-sm btn-danger mx-1"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            ';

                return $btn;
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
            ->rawColumns(['Status', 'action', 'description', 'video'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Video $model): QueryBuilder
    {
        return $model->where('author', Auth::user()->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('video-table')
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
            Column::make('id'),
            Column::make('video'),
            Column::make('description'),
            Column::make('Status')->width(200),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Video_' . date('YmdHis');
    }
}
