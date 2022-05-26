<template>
<div class="row g-3">
    <div class="col-sm-4" v-for="(list,index) in lists" v-bind:key="index">
        <div class="card">
            <div class="card-body">
                <p :class="'text-'+list.color+' fw-bold mb-4'">
                    <i :class="'bx '+list.icon+' h2 text-'+list.color+' align-middle mb-0 me-3'"></i>
                    {{ list.name }}
                </p>
                <div class="row">
                    <div class="col-6">
                        <div>
                            <h5>{{ list.total }}</h5>
                            <p class="text-truncate mb-0" :class="[(list.number < 0) ? 'text-danger' : 'text-success']"> {{ list.number }} ({{ list.percent }}%)
                                <i class="mdi ms-1" :class="[(list.number < 0) ? 'mdi-arrow-down' : 'mdi-arrow-up']"></i>
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <apexchart class="apex-charts" height="40" type="area" dir="ltr"
                            :series="list.series" :options="chartOptions"></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['lists'],
    data(){
        return{
            series: [{
                name: 'BTC',
                data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14]
            }],
            colors : ['bg-success','bg-warning','bg-primary','bg-danger','bg-info','bg-seconday'],
            chartOptions: {
                chart: {
                    type: 'area',
                    height: 40,
                    sparkline: {
                        enabled: true
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#f1b44c'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [25, 100, 100, 100]
                    },
                },
                tooltip: {
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: true
                    },
                    marker: {
                        show: false
                    }
                }
            }
        }
    }
}
</script>