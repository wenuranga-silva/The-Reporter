@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-12">

                <div class="card shadow">

                    <div class="card-body">

                        <div ><canvas id="ViewsChart"></canvas></div>
                        <div style="margin: 40px 0"><canvas id="catChart"></canvas></div>

                    </div>
                </div>

            </div>
        </div>

    </div>


@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        ///// data table
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            //// get data
            function getData(key) {

                return $.ajax({
                    type: "GET",
                    url: '{{ route('admin.dashboard.get.data') }}',
                    data: {
                        _key: key
                    }
                })
            }

            ////// charts
            const views_monthsChart = document.getElementById('ViewsChart')
            const views_CatChart = document.getElementById('catChart')

            //// create chart with data
            async function fetchAndProcessData() {


                try {

                    //// views - month chart
                    var _label = []
                    var _data = []

                    const response = await getData('ViewsMonths')
                    const viewMonth = response.data

                    for (let i = 0; i < viewMonth.length; i++) {

                        _label.push(viewMonth[i]['month'])
                        _data.push(viewMonth[i]['_count'])
                    }


                    new Chart(views_monthsChart, {
                        type: 'bar',
                        data: {
                            labels: _label,
                            //labels: ,
                            datasets: [{
                                label: '# Views - Months',
                                data: _data,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Views - Months'
                                }
                            }
                        }
                    })


                    //// views - category chart

                    var _labelCat = []
                    var _dataCat = []

                    const responseCat = await getData('ViewsCat')
                    const viewCat = responseCat.data

                    for (let i = 0; i < viewCat.length; i++) {

                        _labelCat.push(viewCat[i]['month'])
                        _dataCat.push(viewCat[i]['_count'])
                    }

                    new Chart(views_CatChart, {
                        type: 'bar',
                        data: {
                            labels: _labelCat,
                            //labels: ,
                            datasets: [{
                                label: '# Views - Category',
                                data: _dataCat,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Views - Category'
                                }
                            }
                        }
                    })

                } catch (error) {
                    console.error('Error')
                }
            }

            fetchAndProcessData()


        })
    </script>
@endpush
