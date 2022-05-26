<template>
    <div>
        <div class="card-body border-bottom">
            <div class="page-title-left">
                <h6 class="fw-bold mb-n1">Gender</h6>
            </div>
        </div>
        <div class="card-body mb-n3" style="height: 150px;">
            <div class="row mt-n3 mb-n4">
                <div class="col-md-6">
                    <apexchart ref="realtimeChart" class="apex-charts" type="pie" height="150" :series="gender"
                        :options="chartOptions">
                    </apexchart>
                </div>
                <div class="col-md-6">
                    <table class="table mb-0 mt-3">
                        <tbody>
                            <tr>
                                <td>Male :</td>
                                <td>{{gender[0]}}</td>
                            </tr>
                            <tr>
                                <td>Female :</td>
                                <td>{{gender[1]}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body border-bottom border-top">
            <div class="page-title-left">
                <h6 class="fw-bold mb-n1">Schools</h6>
            </div>
        </div>
        <div class="card-body" style="height: 143px;">
             <table class="table table-centered table-nowrap align-middle" style="table-layout: fixed;">
                <thead class="thead-light">
                    <tr class="font-size-10">
                        <th class="text-center">Private</th>
                        <th class="text-center">Public</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody class="font-size-11">
                    <tr>
                        <td v-for="(s,index) in school" v-bind:key="index" class="text-center fw-bold">{{ s }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['gender','school'],
        data() {
            return {
                currentUrl: window.location.origin,
                colors: ['bg-primary', 'bg-danger', 'bg-success', 'bg-warning', 'bg-info', 'bg-seconday'],
                series: [],
                chartOptions: {
                    chart: {
                        type: 'pie',
                        height: 100,
                    },
                    labels: ['Male', 'Female'],
                    colors: ['#0d68e3', '#e21673'],
                    legend: {
                        show: false,
                    }
                }
            }
        }
    }

</script>
