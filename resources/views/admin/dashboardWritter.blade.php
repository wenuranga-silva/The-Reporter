@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-12">



        </div>
    </div>

</div>


<div style="width: 800px;"><canvas id="commentChart"></canvas></div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('commentChart')

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })
    </script>
@endpush
