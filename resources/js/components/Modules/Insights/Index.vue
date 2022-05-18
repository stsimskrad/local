<template>
    <div>
        <div class="row g-3">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row g-3">
                    <div class="col-sm-4" v-for="(list,index) in lists" v-bind:key="index">
                        <div class="card">
                            <div class="card-body">
                                <p :class="'text-'+list.color+' fw-bold mb-4'">
                                    <i :class="'bx '+list.icon+' h2 text-'+list.color+' align-middle mb-0 me-3'"></i> {{ list.name }} 
                                </p>
                                <div class="row">
                                    <div class="col-6">
                                        <div>
                                            <h5>{{ list.total }}</h5>
                                            <p class="text-muted text-truncate mb-0"> + 0.0012 ( 0.2 % ) 
                                                <i class="mdi mdi-arrow-up ms-1 text-success"></i>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                          <apexchart
                                            class="apex-charts"
                                            height="40"
                                            type="area"
                                            dir="ltr"
                                            :series="list.series"
                                            :options="chartOptions"
                                        ></apexchart>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            currentUrl: window.location.origin,
            lists : {},
            series: [{
                name: 'BTC',
                data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14]
            }],
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
    },

    created(){
        this.fetch();
    },

    methods : {
         fetch() {
            axios.get(this.currentUrl + '/insights/lists')
            .then(response => {
                this.lists = response.data;
            })
            .catch(err => console.log(err));
        },
    }
}
</script>
