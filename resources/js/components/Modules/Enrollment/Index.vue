<template>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div>
                    <div class="card-body border-bottom">
                        <div class="col-md-12 mb-n2" style="margin-top: -6px;">
                            <div class="search-box input-group bg-light rounded">
                                <input type="text" placeholder="Search" class="form-control bg-transparent border-0"
                                    v-model="keyword" v-on:keyup.enter="fetch()">
                                <i class="bx bx-search-alt search-icon"></i>
                                <button type="button" class="btn btn-danger">
                                    <i class='bx bx-search-alt'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom" v-if="user.hasOwnProperty('profile')">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <div class="me-3">
                                    <img :src="currentUrl+'/images/avatars/'+user.profile.avatar" alt=""
                                        class="avatar-sm rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <p class="text-primary fs-14 fw-bold mb-0">{{ user.profile.firstname }}
                                            {{ user.profile.middlename[0] }}.
                                            {{ user.profile.lastname}} {{ user.profile.suffix}}</p>
                                        <p class="mb-0"><span
                                                :class="'badge bg-'+user.status.color">{{user.status.name}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-n4">
                                <div class="col-md-12">
                                    <div class="mb-n3">
                                        <p class="text-muted">
                                            <i class="bx bxs-school font-size-16 align-middle text-primary me-1"></i>
                                            <span class="text-muted font-size-11">School</span> : <span
                                                class="fw-bold font-size-11">{{ user.education.school.name }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-muted">
                                            <i
                                                class="bx bxs-graduation font-size-16 align-middle text-primary me-1"></i>
                                            <span class="text-muted font-size-11">Course</span> : <span
                                                class="fw-bold font-size-11">{{ user.education.course.name }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" :style="{ height: (height-252) + 'px' }"
                        v-if="user.hasOwnProperty('profile')">
                        <div class="row">
                            <simplebar class="align-items-center d-flex justify-content-center"
                                :style="{ height: (hayt-350) + 'px' }">
                                <div class="table-responsive" v-if="user.enrollments.length > 0">
                                    <table class="table table-nowrap align-mid table-hover mb-0">
                                        <tbody>
                                            <tr v-for="list in user.enrollments" v-bind:key="list.id">
                                                <td>
                                                    <i @click="win(list.attachment.enrollments.file)"
                                                        class='bx bxs-file-pdf font-size-24 mt-1 me-n3'
                                                        style="cursor: pointer;"></i>
                                                </td>
                                                <td @click="fetchLists(list)" style="cursor: pointer;">
                                                    <h5 class="text-truncate font-size-13 mb-0">
                                                        <a href="javascript: void(0);" class="text-dark">
                                                            {{ list.academic_year }}
                                                            <span class="text-muted">/</span>
                                                            <span class="text-info">{{ list.level }}</span>
                                                            <span class="text-muted">/</span>
                                                            <span class="text-warning">{{ list.semester }}</span>
                                                        </a>
                                                    </h5>
                                                    <p class="text-muted mb-0 font-size-12">{{ list.created_at}}</p>
                                                </td>
                                                <td>
                                                    <div v-if="list.is_clear == 1" class="font-size-22"><i
                                                            :class="[(list.is_locked == 0) ? 'bx bxs-check-circle' : 'bx bxs-lock-alt',(list.has_failing > 0) ? 'text-danger': 'text-success']"></i>
                                                    </div>
                                                    <div v-else class="font-size-22 text-info"><i
                                                            class="bx bxs-error-circle "></i></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="justify-content-center" v-else>
                                    <div class="col-xl-12">
                                        <center><i @click="addNew" class='bx bxs-plus-circle h1 text-danger mt-5'
                                                style="cursor: pointer;"></i></center>
                                        <p class="text-muted text-center font-size-11">No enrollment record found.
                                        </p>
                                    </div>
                                </div>
                            </simplebar>
                        </div>
                    </div>

                    <div class="card-body" :style="{ height: (height-65) + 'px' }" v-else>
                        <div class="col-xl-12 mb-3">
                            <div class="page-title-left mt-n2 ms-n3 mb-n3">
                                <ol class="breadcrumb m-0 font-size-15">
                                    <li class="breadcrumb-item text-primary fw-bold">{{latest.group.academic_year}}</li>
                                    <li class="breadcrumb-item active"><span>{{latest.group.semester.name}}</span></li>
                                </ol>
                            </div>
                        </div>
                        <div class="card shadow-none border mt-n2">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div>
                                            <p class="text-muted mb-0">Ongoing</p>
                                            <h5> {{ latest.ongoing }} Scholars</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-sm-end mt-4 mt-sm-0">
                                            <p class="text-muted mb-0">Enrolled </p>
                                            <h5> {{ latest.enrolled.length }} Scholars</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="card-body mb-n2 border-top">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <p class="text-warning fw-bold mb-0 font-size-11">{{ failures[0].name }}</p>
                                <h5>{{ failures[0].count }} <span class="fw-bold font-size-13">Scholar/'s</span></h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end mt-4 mt-sm-0">
                                <p class="text-danger fw-bold mb-0 font-size-11">{{ failures[1].name }}</p>
                                <h5>{{ failures[1].count }} <span class="fw-bold font-size-13">Scholar/'s</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top" :style="{ height: (hayt-218) + 'px' }">
                    <h6 class="fw-bold mb-3 me-2">Most Failed Subjects</h6>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <tbody>
                                <tr v-for="(subject,index) in failures[2].data.data" v-bind:key="index" style="cursor: pointer;">
                                    <td>
                                        <h5 class="font-size-13 mb-0">{{subject.code}}</h5>
                                        <p class="text-muted mb-0">{{subject.subject}}</p>
                                    </td>
                                    <td class="text-end">
                                        <h5 class="mb-0">{{subject.total}}</h5>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
                    </div>

                    <div class="card-body border-top" style="padding: 12px;" v-if="user.hasOwnProperty('profile')">
                        <div class="col-md-12 d-grid mt-0">
                            <!-- :disabled="count != 0" -->
                            <button @click="addNew()" type="button" class="btn btn-light btn-sm btn-block">
                                <i class="text-muted bx bx-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <Prospectus :height="height" v-if="show == 'prospectus'" ref="prospectus" />
                <Create v-else-if="show == 'create'" @status="message" :height="height" :user="user"
                    :dropdowns="dropdowns" ref="create" />
                <Lists v-else-if="show == 'lists'" @status="message" :height="height" :lists="lists"
                    :selected="selected" :user="user.code" ref="lists" />
                <Default :height="height" v-else />
                <Course @status="update" ref="course" />
            </div>
        </div>
    </div>
</template>
<script>
    import Course from "./Modals/Course.vue"
    import simplebar from "simplebar-vue";
    import Lists from "./Modules/Lists.vue";
    import Create from "./Modules/Create.vue";
    import Prospectus from "./Modules/Prospectus.vue";
    import Default from "./Modules/Default.vue";
    export default {
        components: {
            simplebar,
            Lists,
            Create,
            Prospectus,
            Default,
            Course
        },
        props: ['height', 'dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                keyword: '',
                user: {},
                lists: [],
                selected: {},
                latest: {
                    group: {
                        semester: {}
                    },
                    enrolled: []
                },
                failures: '',
                show: 'default'
            }
        },

        computed: {
            levels: function () {
                return this.dropdowns.filter(x => x.classification === 'Level');
            },
            statuses: function () {
                return this.dropdowns.filter(x => x.classification === 'Status');
            },
            hayt: function () {
                if (this.advanced) {
                    return this.height - 72;
                } else {
                    return this.height;
                }
            },
        },

        created() {
            this.getLatest();
            this.fetchFails();
        },

        methods: {
            getLatest() {
                axios.get(this.currentUrl + '/request/evaluation/enrollment/info')
                    .then(response => {
                        this.latest = response.data;
                    })
                    .catch(err => console.log(err));
            },

            fetchFails() {
                axios.get(this.currentUrl + '/request/evaluation/enrollment/reports')
                    .then(response => {
                        this.failures = response.data;
                    })
                    .catch(err => console.log(err));
            },

            fetch() {
                let key;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword: key = '-';
                axios.get(this.currentUrl + '/request/scholar/search/' + key)
                    .then(response => {
                        this.user = response.data.data;
                        if (this.user.education.subcourse == null) {
                            this.$bvModal.show("course");
                            this.$refs.course.set(this.user.id, this.user.profile, this.user.education.school, this
                                .user.education.course);
                        } else {
                            this.show = "prospectus";
                            this.$nextTick(function () {
                                this.$refs.prospectus.set(this.user.education.information)
                            });
                        }
                        this.check();
                        // this.lists = [];
                        // this.show = 'empty';
                    })
                    .catch(err => console.log(err));
            },

            fetchLists(list) {
                this.show = 'lists';
                this.selected = list;
                axios.get(this.currentUrl + '/request/evaluation/enrollment/lists/' + list.id)
                    .then(response => {
                        this.lists = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            message(list) {
                let index = this.user.enrollments.findIndex(u => u.id === list.id);
                if (index >= 0) {
                    this.$set(this.user.enrollments, index, list);
                    this.check();
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                } else {
                    this.user.enrollments.unshift(list);
                    this.check();
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    this.fetchLists(list);
                }
            },

            set(show) {
                this.show = show;
                if (show == 'prospectus') {
                    this.$nextTick(function () {
                        this.$refs.prospectus.set(this.user.education.information)
                    });
                } else {
                    this.user = {};
                    this.keyword = '';
                }
            },

            addNew() {
                this.show = 'create';
                this.$nextTick(function () {
                    this.$refs.create.fetchSemesters(this.user.education.school.id, this.user.awarded_year);
                });
            },

            check() {
                if (this.user.enrollments.length > 0) {
                    let count;
                    count = this.user.enrollments.filter(x => x.is_locked === 0);
                    this.count = count.length;
                }
            },

            update(user) {
                this.user = user;
            },

        }
    }

</script>
