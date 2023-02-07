(function () {
    'use strict';

    // ============
    // Area Chart 1
    // ============

    var areaChart1 = {
        chart: {
            height: 240,
            type: 'area',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 1000
            },
            dropShadow: {
                enabled: true,
                opacity: 0.1,
                blur: 1,
                left: -5,
                top: 18
            },
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            },
        },
        colors: ['#0134d4', '#ea4c62'],
        dataLabels: {
            enabled: false
        },
        fill: {
            type: "gradient",
            gradient: {
                type: "vertical",
                shadeIntensity: 1,
                inverseColors: true,
                opacityFrom: 0.15,
                opacityTo: 0.02,
                stops: [40, 100],
            }
        },
        grid: {
            borderColor: '#dbeaea',
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: false,
                }
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            offsetY: 4,
            fontSize: '14px',
            markers: {
                width: 9,
                height: 9,
                strokeWidth: 0,
                radius: 20
            },
            itemMargin: {
                horizontal: 5,
                vertical: 0
            }
        },
        title: {
            text: '5.394 Ton',
            align: 'left',
            margin: 0,
            offsetX: 0,
            offsetY: 20,
            floating: false,
            style: {
                fontSize: '16px',
                color: '#8480ae'
            },
        },
        tooltip: {
            theme: 'dark',
            marker: {
                show: true,
            },
            x: {
                show: false,
            }
        },
        subtitle: {
            text: 'Produksi Pertanian',
            align: 'left',
            margin: 0,
            offsetX: 0,
            offsetY: 0,
            floating: false,
            style: {
                fontSize: '14px',
                color: '#8480ae'
            }
        },
        stroke: {
            show: true,
            curve: 'smooth',
            width: 3
        },
        labels: ['S', 'S', 'M', 'T', 'W', 'T', 'F'],
        series: [{
            name: 'Padi',
            data: [320, 420, 395, 350, 410, 355, 360]
        }, {
            name: 'Jagung',
            data: [400, 395, 350, 395, 430, 385, 374]
        }],
        xaxis: {
            crosshairs: {
                show: true
            },
            labels: {
                offsetX: 0,
                offsetY: 0,
                style: {
                    colors: '#8480ae',
                    fontSize: '12px',
                },
            },
            tooltip: {
                enabled: false,
            },
        },
        yaxis: {
            labels: {
                offsetX: -10,
                offsetY: 0,
                style: {
                    colors: '#8480ae',
                    fontSize: '12px',
                },
            }
        },
    }

    var areaChart_01 = new ApexCharts(document.querySelector("#areaChart1"), areaChart1);
    areaChart_01.render();

})();