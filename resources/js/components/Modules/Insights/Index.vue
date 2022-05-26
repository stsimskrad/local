<template>
    <div class="row g-3">
        
        <div class="col-xl-8">
            <Count :lists="lists"/>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body" style="height: 137px;">
                    s
                </div>
            </div>
        </div>

        <div class="col-xl-8 mt-n2">
            <div class="card">
                <div class="card-body" style="height: 440px;">
                    <Lists data-simplebar style="height: 400px; overflow-y: auto; overflow-x: hidden;"/>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mt-n2">
           <div class="card">
                <div class="card-body border-bottom">
                    <div class="page-title-left">
                        <h6 class="fw-bold mb-n1">Statuses</h6>
                    </div>
                </div>
                <div class="card-body" style="height: 388px;">
                    s
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-n2">
            <div class="card">
                <div class="card-body">
                    <Year />
                </div>
            </div>
        </div>
        <div class="col-xl-4 mt-n2">
            <div class="card">
                <School :schools="schools" :total="total"/>
            </div>
        </div>
        <div class="col-xl-4 mt-n2">
            <div class="card">
                <Course :courses="courses" :total="total"/>
            </div>
        </div>
        <div class="col-xl-4 mt-n2">
            <div class="card">
                <Gender :gender="gender" :school="school"/>
            </div>
        </div>
        <!-- <div class="col-xl-8">

            <Count :lists="lists"/>

            <div class="row">
                <div class="col-sm-12 mt-n2">
                    <div class="card">
                        <div class="card-body" style="height: 440px;">
                            <Lists data-simplebar style="height: 400px; overflow-y: auto; overflow-x: hidden;"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
            <Program :types="types" :main="main" :colors="colors"/>
        </div>
        <div class="col-xl-12 mt-n2">
            <div class="card">
                <div class="card-body">
                    <Year />
                </div>
            </div>
        </div> -->
    </div>
</template>
<script>
    import Count from "./Sections/Count.vue";
    import Program from "./Sections/Program.vue";
    import Year from "./Sections/Year.vue";
    import Lists from "../Home/Coordinator/Lists.vue";
    import School from "./Sections/School.vue";
    import Course from "./Sections/Course.vue";
    import Gender from "./Sections/Gender.vue";
    export default {
        components : { Count, Program, Year, Lists, School, Course, Gender },
        data() {
            return {
                currentUrl: window.location.origin,
                lists: {},
                schools: [],
                courses: [],
                years: [],
                gender: [],
                school: [],
                total: '',
                types: { lists : []},
                colors : ['bg-primary','bg-danger','bg-success','bg-warning','bg-info','bg-seconday'],
                series: [],
                chartOptions: {
                    chart: {
                        type: 'pie',
                        height: 100,
                    },
                    labels: ['Male', 'Female'],
                    colors: ['#556ee6', '#34c38f'],
                    legend: {
                        show: false,
                    }
                }
            }
        },

        created() {
            this.fetch();
        },

        computed : {
            main(){
                return this.types.lists.filter(car => car.is_sub == 0);
            }
        },

        methods: {
            fetch() {
                axios.get(this.currentUrl + '/insights/lists')
                .then(response => {
                    this.lists = response.data.arr;
                    this.types = response.data.types;
                    this.gender = response.data.types.gender;
                    this.school = response.data.types.schools;
                    this.schools = response.data.schools;
                    this.courses = response.data.courses;
                    this.total = response.data.total;
                    // this.$refs.realtimeChart.updateSeries(response.data.types.gender, false, true);
                })
                .catch(err => console.log(err));
            }
        }
    }

</script>
