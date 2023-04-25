<div class="row  p-1">
    <div class="col-sm-3 mb-2 ">
        <div id="card-top-1-1" class="card  border-0 Regular shadow">
            <div class="card-header">
                Receita
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title">R$ 25.8000,00</h5>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi btn btn-outline-light bi-graph-up-arrow "></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 mb-2 ">
        <div id="card-top-1-2" class="card  border-0 Regular shadow">
            <div class="card-header">
                Despesa
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title">R$ 25.8000,00</h5>
                    </div>

                    <div class="col-4 text-center">
                        <i class="bi btn btn-outline-light bi-graph-down-arrow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 mb-2 ">
        <div id="card-top-1-3" class="card  border-0 Regular shadow">
            <div class="card-header">
                Caixa
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8  ">
                        <h5 class="card-title">R$ 25.8000,00</h5>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi bi-bag-fill btn btn-outline-light"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 mb-2 ">
        <div id="card-top-1-4" class="card  border-0 Regular shadow">
            <div class="card-header">
                Vendas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8  ">
                        <h5 class="card-title">R$ 25.8000,00</h5>
                    </div>
                    <div class="col-4 text-center">
                        <i class="bi bi-cart-check btn btn-outline-light"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row m-1 mb-3">
    <div class="col-md-6 p-0  shadow">
        <div class="card">
            <div class="card-header header-card-dashboard  border-0">
                <h6> Receita por periodo</h6>
            </div>
            <div class="card-body">
                <canvas id="myChart-1"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 6 p-0 shadow">
        <div class="card">
            <div class="card-header header-card-dashboard   border-0">
                <h6> Receita por periodo</h6>
            </div>
            <div class="card-body">
                <canvas id="myChart-2"></canvas>
            </div>
        </div>
    </div>

</div>


<div class="row m-1">
    <div class="col-md-6 p-0  shadow">
        <div class="card">
            <div class="card-header header-card-dashboard  border-0">
                <h6> Contas a receber hoje</h6>
            </div>
            <div class="card-body">
                <div class="tabela-dashboard">
                    <table class="table table-hover">
                        <thead>

                            <tr>
                                <th scope="col">Data vencimento</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Valor</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>20/05/2023</td>
                                <td>EFFMAX</td>
                                <td>150</td>
                            </tr>
                            <tr>
                                <td>20/05/2023</td>
                                <td>EFFMAX</td>
                                <td>150</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                            <th scope="col">300</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6 p-0  shadow">
        <div class="card">
            <div class="card-header header-card-dashboard  border-0">
                <h6>Contas a pagar hoje</h6>
            </div>
            <div class="card-body">
                <div class="tabela-dashboard">
                    <table class="table table-hover">
                        <thead>

                            <tr>
                                <th scope="col">Data vencimento</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Valor</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>20/05/2023</td>
                                <td>EFFMAX</td>
                                <td>150</td>
                            </tr>
                            <tr>
                                <td>20/05/2023</td>
                                <td>EFFMAX</td>
                                <td>150</td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                            <th scope="col">300</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>






















<script>
    var ctx = document.getElementById("myChart-1").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false,

            },

        }
    });
    var config = {
        type: 'bar',
        data: {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
            datasets: [{
                    label: 'Receita',
                    data: [10000, 12000, 15000, 18000, 20000, 22000],
                    type: 'line',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    yAxisID: 'y-axis-1',
                },
                {
                    label: 'Despesa',
                    data: [8000, 10000, 12000.50, 14000, 16000, 18000],
                    type: 'line',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    yAxisID: 'y-axis-1',
                },
                {
                    label: 'Lucro',
                    data: [2000, 2000, 3000, 4000, 4000, 4000],
                    type: 'line',
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    yAxisID: 'y-axis-2',
                }
            ]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        var formattedValue = numeral(value).format('$0,0.00');
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + formattedValue;
                    }
                }
            },
            plugins: {
                labels: {
                    render: 'value',
                    fontColor: 'black',
                    fontSize: 14,
                    fontStyle: 'bold',
                    position: 'outside',
                    textMargin: 10,
                    format: function(value) {
                        return 'R$ ' + value.toLocaleString('pt-BR');
                    }
                }
            },
            scales: {
                yAxes: [{
                    type: 'linear',
                    display: true,
                    position: 'left',
                    id: 'y-axis-1',
                }, {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    id: 'y-axis-2',
                    gridLines: {
                        drawOnChartArea: false,
                    },
                }],
            }
        }
    };
    var myChart = new Chart(
        document.getElementById('myChart-2'),
        config
    );
</script>