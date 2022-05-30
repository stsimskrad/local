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
                        <Lists data-simplebar style="height: 400px; overflow-y: auto; overflow-x: hidden;" />
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
                        <div class="card mb-3">
                            <div class="card-body" style="height: 218px;">
                                <div class="card border shadow-none">
                                    <div class="p-1">
                                        <router-link :to="'/qualifier/lists'"><button type="button"
                                                class="float-end btn btn-sm w-sm btn-light mt-1 me-1">View</button>
                                        </router-link>
                                        <div class="d-flex mt-1">
                                            <div class="avatar-xs align-self-center ml-2 mr-2">
                                                <div class="avatar-title rounded bg-transparent">
                                                    <i class="text-primary bx bxs-user-circle h4 mt-1"></i>
                                                </div>
                                            </div>
                                            <div class="overflow-hidden mr-auto align-self-center">
                                                <h5 class="text-primary fw-bold font-size-12 mt-1">Qualifiers</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-centered table-bordered table-sm table-nowrap mt-n mb-0">
                                    <thead class="thead-light">
                                        <tr class="font-size-10">
                                            <th class="text-center">Endorsement Request</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">aw</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-centered table-bordered table-sm table-nowrap mb-0">
                                    <thead class="thead-light">
                                        <tr class="font-size-10">
                                            <th style="width: 50%;" class="text-center"
                                                v-for="(value, name, index) in qualifiers" v-bind:key="index">{{ name }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 50%;" class="text-center"
                                                v-for="(value, index) in qualifiers" v-bind:key="index">{{ value }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mt-n1" style="height: 210px;">
                                <div class="card border shadow-none">
                                    <div class="p-1">
                                        <button type="button" class="float-end btn btn-sm w-sm btn-light mt-1 me-1">Set
                                            Year</button>
                                        <div class="d-flex mt-1">
                                            <div class="avatar-xs align-self-center ml-2 mr-2">
                                                <div class="avatar-title rounded bg-transparent">
                                                    <i class="text-primary bx bxs-calendar h4 mt-1"></i>
                                                </div>
                                            </div>
                                            <div class="overflow-hidden mr-auto align-self-center">
                                                <h5 class="text-primary font-size-12 fw-bold mt-1">Academic Year</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6>
                                    <i class='bx bx-chevrons-right text-primary'></i>
                                    {{ academic_year.group.academic_year }} - {{ academic_year.group.semester.name }}
                                    <span class="font-size-10 text-success">(Active)</span>
                                </h6>
                                <hr>
                                <table class="table table-centered table-bordered table-sm table-nowrap mt-3 mb-0">
                                    <thead class="thead-light">
                                        <tr class="font-size-10">
                                            <th style="width: 50%;" class="text-center">Enrolled</th>
                                            <th style="width: 50%;" class="text-center">Ongoing Scholars</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 50%;" class="text-center">{{ academic_year.enrolled }}
                                            </td>
                                            <td style="width: 50%;" class="text-center">{{ academic_year.ongoing }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-8">
                <div class="card mt-n2">
                    <div class="card-body" style="height: 382px;">
                        <b-tabs justified nav-class="nav-tabs-custom" content-class="p-3 text-muted">
                            <b-tab active class="border-0">
                                <template v-slot:title>
                                    <span class="d-inline-block d-sm-none">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <span class="d-none d-sm-inline-block">Endorsements</span>
                                </template>
                                <Endorsement />
                            </b-tab>
                            <b-tab>
                                <template v-slot:title>
                                    <span class="d-inline-block d-sm-none">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <span class="d-none d-sm-inline-block">Reimbursements</span>
                                </template>
                                {{ content }}
                            </b-tab>
                            <b-tab>
                                <template v-slot:title>
                                    <span class="d-inline-block d-sm-none">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <span class="d-none d-sm-inline-block">Tracer Request</span>
                                </template>
                                {{ text }}
                            </b-tab>
                            <b-tab>
                                <template v-slot:title>
                                    <span class="d-inline-block d-sm-none">
                                        <i class="fas fa-cog"></i>
                                    </span>
                                    <span class="d-none d-sm-inline-block">Requests</span>
                                </template>
                                {{ content }}
                            </b-tab>
                        </b-tabs>

                    </div>
                    <!-- <div class="card-body" style="height: 330px;">
                        <div class="simplebar-content" style="padding: 0px;">
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
                                        <th class="text-center">Program</th>
                                    </tr>
                                </thead>
                                <tbody class="font-size-11">
                                    <tr v-for="(endorsement,index) in endorsements" v-bind:key="index">
                                        <td>{{ index+1 }}</td>
                                        <td class="text-truncate">{{endorsement.name }}</td>
                                        <td class="text-center fw-bold">{{endorsement.information.program_id.name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- <div class="col-md-4">
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
                        <div class="text-center my-3"><a href="javascript:void(0);" class="text-success">See All .. </a>
                        </div>
                    </div>

                </div>
            </div> -->
            <div class="col-md-4">
                <div class="card mt-n2">
                    <div class="card-body border-bottom">
                        <div class="page-title-left">
                            <h6 class="fw-bold mb-n1">REIMBURSEMENTS</h6>
                        </div>
                    </div>
                    <div class="card-body align-items-center d-flex justify-content-center" style="height: 138px;">
                        <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-info align-middle">No
                            reimbursement request found.</div>
                    </div>
                    <div class="card-body border-bottom border-top">
                        <div class="page-title-left">
                            <h6 class="fw-bold mb-n1">REQUESTS</h6>
                        </div>
                    </div>
                    <div class="card-body align-items-center d-flex justify-content-center" style="height: 139px;">
                        <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-info align-middle">No
                            information request found.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Lists from "./Lists.vue";
    import Reimbursement from "./Tabs/Reimbursement.vue";
    import Endorsement from "./Tabs/Endorsement.vue";
    import Request from "./Tabs/Endorsement.vue";
    import Tracer from "./Tabs/Tracer.vue";

    export default {
        components: {Lists, Reimbursement, Endorsement, Request, Tracer},
        data() {
            return {
                currentUrl: window.location.origin,
                totals: [],
                staffs: [],
                academic_year: {
                    group: {
                        semester: {}
                    }
                },
                schools: [],
                courses: [],
                qualifiers: [],
                endorsements: [],
                text: `
         Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.
        `,
                content: `Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus.`

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
                        this.staffs = response.data.staffs;
                        this.academic_year = response.data.academic_year;
                        this.schools = response.data.schools;
                        this.courses = response.data.courses;
                        this.qualifiers = response.data.qualifiers;
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
