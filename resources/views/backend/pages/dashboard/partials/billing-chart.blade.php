<div class="bg-white p-4 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">{{ __('Monthly Billing') }}</h2>
    <div id="monthlyBillingChart" style="height: 300px;"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chart = new ApexCharts(document.querySelector("#monthlyBillingChart"), {
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            series: [{
                name: 'Total Billed',
                data: billingData
            }],
            xaxis: {
                categories: billingLabels,
                labels: {
                    style: {
                        fontSize: '13px',
                        colors: '#6B7280'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    formatter: (val) => `$${val.toLocaleString()}`,
                    style: {
                        fontSize: '13px',
                        colors: '#6B7280'
                    }
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '25%', // smaller width
                    distributed: false
                    // No borderRadius
                }
            },
            fill: {
                type: 'solid',
                colors: ['#4F46E5']
            },
            dataLabels: {
                enabled: true,
                formatter: (val) => `$${val.toLocaleString()}`,
                offsetY: -10,
                style: {
                    fontSize: '12px',
                    colors: ['#374151']
                }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return `$${val.toLocaleString()}`;
                    }
                }
            },
            grid: {
                borderColor: '#E5E7EB',
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                }
            }
        });

        chart.render();
    });
</script>

