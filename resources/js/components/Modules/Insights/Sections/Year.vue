<template>
    <div>
        <div class="clearfix mb-3">
            <div class="float-end">
                <div class="input-group input-group-sm">
                    <select v-model="is_undergrad" class="form-select form-select-sm" @change="fetch()" style="width: 220px;">
                        <option :value="null" selected>All Scholars</option>
                        <option :value="1" selected>Undergraduate</option>
                        <option :value="0" selected>JLSS</option>
                    </select>
                     <select v-model="province" class="form-select form-select-sm" @change="fetch()" style="width: 220px;">
                        <option :value="null" selected>All Provinces</option>
                        <option :value="province.code" v-for="province in provinces" v-bind:key="province.id">{{ province.name }}
                        </option>
                    </select>
                    <label class="input-group-text">Filter</label>
                </div>
            </div> 
            <h6>Scholarship Program Awarded Through the Years</h6>
            <!-- <div class="float-end">
                <div class="input-group input-group-sm">
                    <select v-model="province" class="form-select form-select-sm" @change="fetch()" style="width: 220px;">
                        <option :value="null" selected>All Province</option>
                        <option :value="province.code" v-for="province in provinces" v-bind:key="province.id">{{ province.name }}
                        </option>
                    </select>
                    <label class="input-group-text">Province</label>
                </div>
            </div>  -->
        </div>
        <apexchart ref="realtimeChart" class="apex-charts mb-n5 mt-2" type="bar" dir="ltr" height="400" :series="series"
            :options="chartOptions">
        </apexchart>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                years: [],
                provinces: [],
                province: null,
                is_undergrad: null,
                series: [],
                chartOptions: {
                    chart: {
                        stacked: true,
                        toolbar: {
                            show: false,
                        },
                        zoom: {
                            enabled: true,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "50%",
                            endingShape: "rounded",
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        labels: {
                            rotate: -45
                        },
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                        tickPlacement: 'on'
                    },
                    yaxis: {
                        title: {
                            text: 'Scholars Count'
                        },
                    },
                    colors: ["#556ee6", "#ea6868", "#34c38f", "#f1b44c", "#a20cce", " #713d3d"],
                    legend: {
                        position: "top",
                    },
                    fill: {
                        opacity: 1,
                    },
                },
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(this.currentUrl + '/insights/years',{
                    params : {
                        province : this.province,
                        is_undergrad : this.is_undergrad
                    }
                })
                .then(response => {
                    this.provinces = response.data.provinces;
                    this.chartOptions = {
                        ...this.chartOptions,
                        ...{
                            xaxis: {
                                labels: {
                                    show: true,
                                    rotate: -65,
                                    rotateAlways: true,
                                    minHeight: 100,
                                    maxHeight: 180,
                                    style: {
                                        colors: "red"
                                    }
                                },
                                categories: response.data.categories,
                                tickPlacement: 'on'
                            }
                        }
                    };
                    this.series = response.data.lists;
                    this.$refs.realtimeChart.updateSeries(this.series, false, true);
                    this.$refs.realtimeChart.updateOptions(this.chartOptions, false, true);

                })
                .catch(err => console.log(err));
            }
        }
    }

</script>
