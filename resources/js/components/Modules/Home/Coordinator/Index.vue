<template>
    <div>
        <div class="row g-3">
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-lg-4" v-for="(total,index) in totals" v-bind:key="index">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="me-3">
                                        <p class="text-muted mb-2">{{ total.name }}</p>
                                        <h5 class="mb-0">{{ total.counts }}</h5>
                                    </div>
                                    <div class="avatar-sm ms-auto">
                                        <div class="avatar-title bg-light rounded-circle font-size-20"
                                            :class="'text-'+total.color">
                                            <i class="bx" :class="total.icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-n2">
                    <div class="card-body" style="height: 440px;">

                        <ul class="list-inline user-chat-nav text-start ms-4 mt-1 dropdown">
                            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                                <button type="button"
                                    class="btn btn-sm w-sm ms-n4 me-n3 ml-1 btn-secondary">Update</button>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                                <i class="bx bxs-check-circle text-success h4"
                                    style="margin-left: -22px; position: absolute;"></i>
                                <span class="text-muted font-size-11">Completed : 1</span>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                                <i class="bx bxs-info-circle text-warning h4"
                                    style="margin-left: -22px; position: absolute;"></i>
                                <span class="text-muted font-size-11">Incomplete : 1</span>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="subprogram"
                                        id="gridCheck" />
                                    <label class="form-check-label font-size-11" for="gridCheck">Show
                                        Sub-Programs</label>
                                </div>
                            </li>
                        </ul>
                        <b-tabs pills nav-class="bg-light rounded" content-class="mt-3" small>
                            <b-tab active title="Provinces">
                                <b-card-text>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-bordered table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr class="font-size-10">
                                                    <th style="width: 20%;" class="text-center">Province</th>
                                                    <th style="width: 13%;" class="text-center"
                                                        v-for="program in programs" v-bind:key="program.id">
                                                        {{ program.name }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table class="table table-centered table-bordered table-nowrap">
                                            <tbody class="font-size-11">
                                                <tr v-for="(province,index) in provinces" v-bind:key="index">
                                                    <td style="width: 20%;" class="text-center">
                                                        {{ province.province.name }}</td>
                                                    <td style="width: 13%;" class="text-center fw-bold"
                                                        v-for="(count,index) in province.count" v-bind:key="index">
                                                        {{ count }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- <table class="table table-centered table-bordered table-nowrap mb-0">
                                        <tfoot class="thead-light">
                                            <tr class="font-size-12">
                                                <th style="width: 80%;" colspan="3"></th>
                                                <th class="text-center text-primary" style="width: 10%;">{{ units }}</th>
                                                <th class="text-center text-primary" style="width: 10%;">{{ total }}</th>
                                            </tr>
                                        </tfoot>
                                    </table> -->
                                    </div>
                                </b-card-text>
                            </b-tab>
                            <b-tab title="Programs">
                                <b-card-text>

                                </b-card-text>
                            </b-tab>
                        </b-tabs>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex" v-if="staffs.length > 0">
                                    <div class="me-3">
                                        <img :src="currentUrl+'/images/avatars/'+staffs[0].avatar" alt=""
                                            class="avatar-sm rounded-circle img-thumbnail">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="text-muted">
                                                    <h5 class="mb-0 mt-1">{{ staffs[0].firstname}}
                                                        {{ staffs[0].lastname}}</h5>
                                                    <p class="mb-0">{{ staffs[0].role}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-n2">
                        <div class="card">
                            <div class="card-body" style="height: 440px;">
                                <div class="card border shadow-none">
                                    <a class="text-body">
                                        <div class="p-1">
                                            <button type="button" class="float-end btn btn-sm w-sm btn-light mt-1">Set
                                                Year</button>
                                            <div class="d-flex mt-1">
                                                <div class="avatar-xs align-self-center ml-2 mr-2">
                                                    <div class="avatar-title rounded bg-transparent">
                                                        <i class="text-success bx bxs-calendar h4 mt-1"></i>
                                                    </div>
                                                </div>
                                                <div class="overflow-hidden mr-auto align-self-center">
                                                    <h5 class="font-size-12 text-muted mt-1">Academic Year</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <h6>
                                    <i class='bx bx-chevrons-right text-primary'></i>
                                    {{ academic_year.academic_year }} - {{ academic_year.semester.name }}
                                    <span class="font-size-10 text-success">(Active)</span>
                                </h6>
                                <div class="card border shadow-none mt-4">
                                    <a class="text-body">
                                        <div class="p-1">
                                            <div class="d-flex mt-1">
                                                <div class="avatar-xs align-self-center ml-2 mr-2">
                                                    <div class="avatar-title rounded bg-transparent">
                                                        <i class="text-secondary bx bxs-cog h4 mt-1"></i>
                                                    </div>
                                                </div>
                                                <div class="overflow-hidden mr-auto align-self-center">
                                                    <h5 class="font-size-12 text-muted mt-1">Settings</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card mt-n2">
                    <div class="card-body border-bottom">
                        <div class="page-title-left">
                            <h6 class="fw-bold mb-n1">MOST SCHOOLS</h6>
                        </div>
                    </div>
                    <div class="card-body" style="height: 330px;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <table class="table table-centered table-nowrap align-middle">
                                <colgroup>
                                    <col width="10%" />
                                    <col width="75%" />
                                    <col width="15%" />
                                </colgroup>
                                <thead class="thead-light">
                                    <tr class="font-size-10">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="text-center">Count</th>
                                    </tr>
                                </thead>
                                <tbody class="font-size-11">
                                    <tr v-for="(school,index) in schools" v-bind:key="index">
                                        <td>{{ index+1 }}</td>
                                        <td class="text-truncate">{{ucwords(school.school.name) }}</td>
                                        <td class="text-center fw-bold">{{school.scholars_count}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center my-3"><a href="javascript:void(0);" class="text-success">See All .. </a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mt-n2">
                    <div class="card-body border-bottom">
                        <div class="page-title-left">
                            <h6 class="fw-bold mb-n1">MOST COURSES</h6>
                        </div>
                    </div>
                    <div class="card-body" style="height: 330px;">
                        <table class="table table-centered table-nowrap align-middle" style="table-layout: fixed;">
                            <colgroup>
                                <col width="10%" />
                                <col width="75%" />
                                <col width="15%" />
                            </colgroup>
                            <thead class="thead-light">
                                <tr class="font-size-10">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Count</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-11">
                                <tr v-for="(course,index) in courses" v-bind:key="index">
                                    <td>{{ index+1 }}</td>
                                    <td class="text-truncate">{{ course.name }}</td>
                                    <td class="text-center fw-bold">{{course.scholars_count}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center my-3"><a href="javascript:void(0);" class="text-success">See All .. </a></div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mt-n2">
                    <div class="card-body border-bottom">
                        <div class="page-title-left">
                            <h6 class="fw-bold mb-n1">REIMBURSEMENTS</h6>
                        </div>
                    </div>
                    <div class="card-body" style="height: 330px;">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                provinces: [],
                programs: [],
                totals: [],
                staffs: [],
                academic_year: {
                    semester: {}
                },
                subprogram: false,
                schools: [],
                courses: []
            }
        },

        created() {
            this.fetch();
            this.fetchTotals();
        },

        methods: {
            fetch() {
                axios.get(this.currentUrl + '/request/dashboard/index')
                    .then(response => {
                        this.provinces = response.data.provinces.provinces;
                        this.programs = response.data.provinces.programs;
                        this.staffs = response.data.staffs;
                        this.academic_year = response.data.academic_year;
                        this.schools = response.data.schools;
                        this.courses = response.data.courses;
                    })
                    .catch(err => console.log(err));
            },

            fetchTotals() {
                axios.get(this.currentUrl + '/request/scholar/reports/totals')
                    .then(response => {
                        this.totals = response.data;
                    })
                    .catch(err => console.log(err));
            },

            ucwords(str) {
                let str1 = str.toLowerCase().trim();
                return (str1 + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                    return $1.toUpperCase();
                });
            }
        }
    }

</script>
