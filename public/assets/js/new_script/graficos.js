var documents = documentos();
var meses_aux = meses();
var aux = [];
var document_aux = [];
var colores = [
    ['#dd2c00', '#ff9e80'],
    ['#ffd600', '#ffff8d'],
    ['#00c853', '#b9f6ca'],
    ['#0091ea', '#80d8ff'],
    ['#6200ea', '#b388ff'],
    ['#d50000', '#ff8a80'],
    ['#ffab00', '#ffe57f'],
    ['#33691e', '#8bc34a'],
    ['#006064', '#00bcd4'],
    ['#1a237e', '#3f51b5'],
];
colores = colores.reverse();
var i_aux = 0;
for (let i in documents) {
    for (let j in documents[i]['totales']) {
        aux.push(documents[i]['totales'][j]);
    }
    var variable = {
        label: documents[i]['name'],
        data: aux.reverse(),
        fill: false,
        borderColor: colores[i_aux][0],
        pointBorderColor: colores[i_aux][1],
        pointBackgroundColor: "#FFF",
        pointBorderWidth: 2,
        pointHoverBorderWidth: 2,
        pointRadius: 4
    }
    aux = [];
    document_aux.push(variable);
    if (colores[(i_aux + 1)] == undefined) {
        i_aux = 0;
        colores = colores.reverse();
    } else
        i_aux++;
}

var mes_aux = [];
for (let i = 0; i < 6; i++) {
    mes_aux.push(meses_aux[i]);
}


var ctx = $("#line-chart");

// Chart Options
var chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
        position: "bottom"
    },
    hover: {
        mode: "label"
    },
    scales: {
        xAxes: [{
            display: true,
            gridLines: {
                color: "#f3f3f3"
            },
            scaleLabel: {
                display: true
            }
        }],
        yAxes: [{
            display: true,
            gridLines: {
                color: "#f3f3f3",
                drawTicks: false
            },
            scaleLabel: {
                display: true
            }
        }]
    },
    title: {
        display: true
    }
};
// Chart Data
var chartData = {
    labels: mes_aux.reverse(),
    datasets: document_aux
};

var config = {
    type: "line",

    // Chart Options
    options: chartOptions,

    data: chartData
};

// Create the chart
var lineChart = new Chart(ctx, config);


// Graficos de Donas


var tipos_documento = tipos_documento();
var grupo_etnia = grupos_etnia();
var genero = genero();
var general = [];
var grupos = [];
var generos = [];
var titulos_aux = [];
var data_aux = [];
var colores_aux = [];
var rojos = ['#d50000', '#ff8a80', '#ff1744', '#ff5252', '#b71c1c', '#ffcdd2', '#c62828', '#ef9a9a', '#d32f2f', '#f44336', '#e57373'];
var amarillos = ['#ffab00', '#ffe57f', '#ffc400', '#ffd740', '#ff6f00', '#ffecb3', '#ffa000', '#ffd54f', '#ffc107'];
var azules = ['#0091ea', '#80d8ff', '#00b0ff', '#40c4ff', '#01579b', '#b3e5fc', '#0288d1', '#4fc3f7', '#03a9f4'];
i_aux = 0;
for (let i in tipos_documento) {
    titulos_aux.push(tipos_documento[i]['descripcion']);
    data_aux.push(tipos_documento[i]['total']);
    colores_aux.push(rojos[i_aux]);
    if (rojos[(i_aux + 1)] == undefined) {
        i_aux = 1;
        rojos = rojos.reverse();
    } else
        i_aux++;
}
general['titulos'] = titulos_aux;
general['data'] = data_aux;
general['colores'] = colores_aux;
titulos_aux = [];
data_aux = [];
colores_aux = [];
i_aux = 0;
for (let i in grupo_etnia) {
    titulos_aux.push(grupo_etnia[i]['grupo_etnia']);
    data_aux.push(grupo_etnia[i]['total']);
    colores_aux.push(amarillos[i_aux]);
    if (amarillos[(i_aux + 1)] == undefined) {
        i_aux = 1;
        amarillos = amarillos.reverse();
    } else
        i_aux++;
}
grupos['titulos'] = titulos_aux;
grupos['data'] = data_aux;
grupos['colores'] = colores_aux;
titulos_aux = [];
data_aux = [];
colores_aux = [];
i_aux = 0;
for (let i in genero) {
    titulos_aux.push(genero[i]['genero']);
    data_aux.push(genero[i]['total']);
    colores_aux.push(azules[i_aux]);
    if (azules[(i_aux + 1)] == undefined) {
        i_aux = 1;
        azules = azules.reverse();
    } else
        i_aux++;
}
generos['titulos'] = titulos_aux;
generos['data'] = data_aux;
generos['colores'] = colores_aux;
// Doughnut chart
// -----------------
//Get the context of the Chart canvas element we want to select
var ctx = $("#general-chart");
var ctx_1 = $("#etnia-chart");
var ctx_2 = $("#genero-chart");

// Chart Options
var chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    responsiveAnimationDuration: 500
};


// Imprimimos Datos
// Chart Data
var chartDataGeneral = {
    labels: general['titulos'],
    datasets: [{
        data: general['data'],
        backgroundColor: general['colores']
    }]
};

var chartDataEtnia = {
    labels: grupos['titulos'],
    datasets: [{
        data: grupos['data'],
        backgroundColor: grupos['colores']
    }]
};

var chartDataGenero = {
    labels: generos['titulos'],
    datasets: [{
        data: generos['data'],
        backgroundColor: generos['colores']
    }]
};

var configGeneral = {
    type: "doughnut",

    // Chart Options
    options: chartOptions,

    data: chartDataGeneral
};

var configEtnia = {
    type: "doughnut",

    // Chart Options
    options: chartOptions,

    data: chartDataEtnia
};
var configGenero = {
    type: "doughnut",

    // Chart Options
    options: chartOptions,

    data: chartDataGenero
};

// Create the chart
var doughnutChart = new Chart(ctx, configGeneral);
var doughnutChart = new Chart(ctx_1, configEtnia);
var doughnutChart = new Chart(ctx_2, configGenero);