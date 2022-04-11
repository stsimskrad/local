<template>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex" v-if="user">
                        <div class="me-3">
                            <img :src="currentUrl+'/images/avatars/'+user.avatar" alt=""
                                class="avatar-sm rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-grow-1 align-self-center">
                            <div class="text-muted">
                                <p class="text-primary fs-14 fw-bold mb-0">{{ user.firstname }}
                                    {{ user.middlename[0] }}.
                                    {{ user.lastname}} {{ user.suffix}}</p>
                                <p class="mb-0"><span :class="'badge bg-'+user.status.color">{{user.status.name}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" :style="{ height: (hayt-248) + 'px' }">
                   
                </div>
                <div class="card-body border-top" style="padding: 12px;">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <p class="text-muted font-size-11 mb-0">Total Benefits</p>
                                <h5>₱ {{formatMoney(total)}}</h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end mt-4 mt-sm-0">
                                <p class="text-muted font-size-11 mb-0">Since last month</p>
                                <h5> + $ 248.35 <span class="badge bg-success ms-1 align-bottom">+ 1.3 %</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" :style="{ height: (hayt-90) + 'px' }" style="overflow: auto;">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="font-size-11">
                                <tr>
                                    <th rowspan="2" style="width: 30%;">#</th>
                                    <th rowspan="2" class="text-center font-size-8" style="width: 10%;">One-time</th>
                                    <th colspan="3" class="text-center" style="width: 30%;">
                                        <div>
                                            <div class="input-group input-group-sm">
                                                <select v-model="year" class="form-select form-select-sm" @change="onChange($event)">
                                                    <option :value="year" v-for="(year,index) in years" v-bind:key="index">{{year}}</option>
                                                    
                                                </select>
                                                <label class="input-group-text">Month</label>
                                            </div>
                                        </div>
                                    </th>
                                    <th :colspan="course" class="text-center" style="width: 30%;">Academic Year</th>
                                </tr>
                                <tr>
                                    <th class="text-center">1st</th>
                                    <th class="text-center">2nd</th>
                                    <th class="text-center">3rd</th>
                                    <th class="text-center" v-for="(c,index) in course" v-bind:key="index">{{c}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="breakdown in breakdowns" v-bind:key="breakdown.id">
                                    <td>{{breakdown.name}}</td>
                                    <td :class="'text-center '+list.selectable" v-for="list in breakdown.lists" v-bind:key="list.id">
                                        <span v-if="list.data != ''" v-html="list.data.val"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                     <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="font-size-11">
                                <tr class="table-primary">
                                    <th rowspan="2" style="width: 30%;">Stipends</th>
                                    <th class="text-center">Month 1</th>
                                    <th class="text-center">Month 2</th>
                                    <th class="text-center">Month 3</th>
                                    <th class="text-center">Month 4</th>
                                    <th class="text-center">Month 5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>
                                    <div>
                                        <div class="input-group input-group-sm">
                                            <select v-model="semester" class="form-select form-select-sm" @change="onChange($event)">
                                                <option :value="semester" v-for="(semester,index) in semesters" v-bind:key="index">{{semester}}</option>
                                                
                                            </select>
                                            <label class="input-group-text">Semester</label>
                                        </div>
                                    </div>
                                </td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['height'],
        data() {
            return {
                currentUrl: window.location.origin,
                user: '',
                total: '',
                breakdowns: '',
                fil: {},
                years: [],
                semesters: ['First Semester','Second Semester','Summer Class'],
                semester: '',
                year:'',
                course: ''
            }
        },
        computed: {
            hayt: function () {
                if (this.advanced) {
                    return this.height - 72;
                } else {
                    return this.height;
                }
            }
        },
        methods: {
            set(user) {
                this.user = user;
                let y = user.awarded_year;

                for (let i = 0; i < user.year.type; i++) {
                    var year =y+'-'+(y+1);
                    this.years.unshift(year);
                    y++;
                }
                this.year = this.years[0];
                this.course = user.course;
                this.fetch();
            },

            fetch(){
                this.fil = {
                    'code' : this.user.code,
                    'year' : this.year,
                    'course': this.user.course,
                    'award' : this.user.awarded_year
                };
                axios.get(this.currentUrl + '/request/benefit/'+JSON.stringify(this.fil))
                .then(response => {
                    this.total = response.data.total;
                    this.breakdowns = response.data.breakdown;
                })
                .catch(err => console.log(err));
            },

            onChange(){
                this.fetch();
            },

            formatMoney(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }
    }
</script>
<style>
    .unselectable {
        background-color: #ddd !important;
        cursor: not-allowed;
    }
</style>