<?php

namespace App\DataTables;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NewsDataTable extends DataTable
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

                        <a href="' . route('admin.news.edit', $query->id) . '" class="btn btn-sm btn-primary mx-3 mb-3"><i class="fas fa-pencil-alt"></i></a>
                        <a href="' . route('admin.news.show', $query->id) . '" class="btn btn-sm btn-secondary mx-3 mb-3"><i class="fas fa-images"></i></a>
                        <a href="' . route('admin.video.news.add', $query->id) . '" class="btn btn-sm btn-secondary mx-3 mb-1"><i class="fab fa-youtube"></i></a>
                        <a href="' . route('admin.news.destroy', $query->id) . '" class="btn btn-sm btn-danger mx-3 mb-1"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
                ';

                return $btn;
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
            ->rawColumns(['Is Comment', 'Status', 'Post Image', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(News $model): QueryBuilder
    {
        return $model->where('author_id', Auth::user()->id)->with(['PostImage'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('news-table')
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
            Column::make('Post Image'),
            Column::make('title'),
            Column::make('Is Comment')->width(200),
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
        return 'News_' . date('YmdHis');
    }
}
