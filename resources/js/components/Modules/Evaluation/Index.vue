<template>
    <div class="row g-3">
        <div class="col-md-12 mb-n4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search-box input-group bg-light rounded">
                                <input type="text" v-model="keyword" placeholder="Search Scholar"
                                    v-on:keyup.enter="fetch" class="form-control bg-transparent border-0">
                                <i class="bx bx-search-alt search-icon"></i>
                                <button @click="fetch" type="button" class="btn btn-primary">
                                    <i class='bx bx-search-alt'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row g-3" v-if="Object.keys(user).length">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex" v-if="user">
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
                        </div>
                        <div class="card-body border-bottom p-2">
                            <div class="mt-1">
                                <p class="font-size-11 text-muted mb-0"><i
                                        class='bx bx-radio-circle-marked me-1 text-primary'></i>{{ user.school.name }}
                                </p>
                                <p class="font-size-11 text-muted mb-1"><i
                                        class='bx bx-radio-circle-marked me-1 text-primary'></i>{{ user.course.name }}
                                </p>
                            </div>
                        </div>
                        <div class="card-body" :style="{ height: (hayt-290) + 'px' }">
                            <div v-if="Object.keys(user).length">
                                <simplebar class="align-items-center d-flex justify-content-center"
                                    :style="{ height: (hayt-320) + 'px' }">
                                    <div class="table-responsive" v-if="user.enrollments.length > 0">
                                        <table class="table table-nowrap align-mid table-hover mb-0">
                                            <tbody>
                                                <tr v-for="list in user.enrollments" v-bind:key="list.id">
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
                        <div class="card-body border-top" style="padding: 12px;">
                            <div class="col-md-12 d-grid mt-0">
                                <!-- :disabled="count != 0" -->
                                <button @click="addNew" type="button" class="btn btn-light btn-sm btn-block">
                                    <i class="text-muted bx bx-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div v-if="show == 'empty'" class="card-body" :style="{ height: (hayt-90) + 'px' }">
                            <!-- 
                                align-items-center d-flex justify-content-center
                                <div class="col-md-2 mx-auto mt-5">
                                <img class="img-fluid" src="/images/svg/employment.svg">
                                <div class="col-xl-12">
                                    <center><i @click="addNew" class='bx bxs-plus-circle h1 text-danger mt-5' style="cursor: pointer;"></i></center>
                                    <p class="text-muted text-center font-size-11">No enrollment record found.</p>
                                </div>
                            </div> -->
                            <Prospectus :height="height" ref="prospectus" />
                        </div>
                        <Create :user="user.id" 
                        :course="user.course" 
                        @status="message" 
                        :dropdowns="dropdowns"
                        :height="height" ref="sem" 
                         v-else-if="show == 'create'"
                        />

                        <Lists v-else :lists="lists" 
                        :height="height" @status="message" 
                        :prospectus="prospectus"/>
                        
                    </div>
                </div>
            </div>
            <div v-else>
                <Dashboard :height="height" />
            </div>
        </div>
        <Course @status="update" ref="course" />
    </div>
</template>
<script>
    import Dashboard from './Dashboard.vue';
    import Prospectus from './Prospectus.vue';
    import Course from './Modals/Course.vue';
    import Create from './Create.vue';
    import Lists from './Lists.vue';
    import Multiselect from 'vue-multiselect';
    import simplebar from "simplebar-vue";
    export default {
        props: ['height', 'dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                keyword: '',
                level: '',
                user: {},
                subcourses: [],
                subcourse: '',
                lists: [],
                show: 'empty',
                prospectus: {},
                pros: {},
                count: 0
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

        methods: {
            fetch() {
                let key;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword: key = '-';

                if (key != '-') {
                    axios.get(this.currentUrl + '/request/evaluation/enrollment/search/' + key)
                        .then(response => {
                            this.user = response.data.data;
                            if (this.user.course.subcourse == null) {
                                this.$bvModal.show("course");
                                this.$refs.course.set(this.user.id, this.user.profile, this.user.school, this.user
                                    .course);
                            } else {
                                this.$nextTick(function () {
                                    this.$refs.prospectus.set(this.user.course)
                                });
                            }
                            this.check();
                            this.lists = [];
                            this.show = 'empty';
                        })
                        .catch(err => console.log(err));
                } else {
                    this.user = {};
                }
            },

            addNew() {
                this.show = 'create';
                this.$nextTick(function () {
                    this.$refs.sem.fetchSemesters(this.user.school.id, this.user.awarded_year);
                });
            },

            fetchLists(list) {
                this.show = 'lists';
                this.prospectus = list;
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

            update(user) {
                this.user = user;
            },

            check() {
                if (this.user.enrollments.length > 0) {
                    let count;
                    count = this.user.enrollments.filter(x => x.is_locked === 0);
                    this.count = count.length;
                }
            }
        },
        components: {
            Multiselect,
            simplebar,
            Create,
            Lists,
            Course,
            Dashboard,
            Prospectus
        }
    }

</script>
