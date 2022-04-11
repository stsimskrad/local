<template>
<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-7">
                    <div class="media">
                        <div class="me-3">
                            <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-sm rounded-circle img-thumbnail">
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-muted">
                                <h5 class="text-primary mb-0">{{ school.name }}</h5>
                                <p class="mb-0">{{school.address}}, {{school.municipality.name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <div class="text-lg-center mt-4 mt-lg-0">
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <p class="text-muted text-truncate mb-2">Ongoing Scholars</p>
                                    <h5 class="mb-0">48</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <p class="text-muted text-truncate mb-2">Graduated Scholars</p>
                                    <h5 class="mb-0">40</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body mb-n3">
                    <div class="float-end">
                        <div class="input-group input-group-sm mt-n1">
                            <b-form-input style="width: 100px;" for="text" v-model="year"></b-form-input>
                            <label class="input-group-text">Year</label>
                        </div>
                    </div>
                    <p class="text-muted fw-bold">Semesters</p>
                </div>
                <div class="card-body border-top">

                    <div class="mt-2">
                        <div class="table-responsive w-100">
                            <simplebar :style="{ height: (height - 250) + 'px' }">
                                <table class="table table-nowrap table-centered table-hover mb-0">
                                    <tbody>
                                        <tr v-for="semester in school.semesters" v-bind:key="semester.id">
                                            <td>
                                                <h5 class="text-truncate font-size-13 mb-0">
                                                    <a href="javascript: void(0);" class="text-dark">
                                                        {{ semester.academic_year }} 
                                                        <span class="text-muted">/</span> 
                                                        <span class="text-info">{{ semester.semester.name }}</span>
                                                    </a>
                                                </h5>
                                                <p class="text-muted mb-0 font-size-12">{{ semester.start_at}} - {{ semester.end_at}}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </simplebar>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top d-grid" style="margin-bottom: -18px;">
                        <button type="button" @click="newSemester" class="btn btn-block btn-light btn-sm waves-effect waves-light">Add Semester</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body mb-n3">
                    <div class="mb-3 float-end">
                        <ul class="mb-0">
                            <li class="list-inline-item d-non d-sm-inline-block mr-4">     
                                <i class='bx bxs-notepad text-success'></i> <span class="text-muted font-size-11">With Prospectus</span>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block mr-4">     
                                <i class='bx bxs-notepad text-danger'></i> <span class="text-muted font-size-11">No Prospectus</span>
                            </li>
                        </ul>
                    </div>
                    <p class="text-muted fw-bold">Courses</p>
                </div>
                <div class="card-body border-top">

                    <div class="mt-2">
                        <div class="table-responsive w-100">
                            <simplebar :style="{ height: (height - 250) + 'px' }">
                                <table class="table table-nowrap table-centered table-hover mb-0">
                                    <tbody>
                                        <tr v-for="course in school.courses" v-bind:key="course.id" @click="view(course)" style="cursor: pointer;">
                                            <td>
                                                <h5 class="text-truncate font-size-12 mb-0"><a href="#" class="text-dark">{{(course.type == 'N/a') ? course.course : course.type}}</a></h5>
                                                <p class="text-muted font-size-11 mb-0" v-if="course.type != 'N/a'">{{course.course}}</p>
                                            </td>
                                            <td class="text-end" style="width: 90px;">
                                                <i class="bx bxs-notepad h5 mr-3 mt-1" :class="[(course.prospectus == null) ? 'text-danger' : 'text-success']"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </simplebar>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top d-grid" style="margin-bottom: -18px;">
                        <button type="button" @click="newCourse" class="btn btn-block btn-light btn-sm waves-effect waves-light">Add Course</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body mb-n3">
                    <div class="mb-3 float-end">
                        <ul class="mb-0">
                            <li class="list-inline-item d-non d-sm-inline-block mr-4">     
                                <i class='bx bxs-circle text-success'></i> <span class="text-muted font-size-11">Activated</span>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block mr-4">     
                                <i class='bx bxs-circle text-danger'></i> <span class="text-muted font-size-11">Not Activated</span>
                            </li>
                        </ul>
                    </div>
                    <p class="text-muted fw-bold">Prospectus</p>
                </div>
                <div class="card-body border-top">
                    <div class="mt-2">
                        <div class="table-responsive w-100">
                            <simplebar :style="{ height: (height - 250) + 'px' }">
                                <div class="text-center mb-3">
                                    <h5 class="text-truncate text-primary font-size-13 mb-0"><span class="text-dark">{{(course.type == 'N/a') ? course.course : course.type}}</span></h5>
                                    <p class="text-muted font-size-11 mb-0" v-if="course.type != 'N/a'">{{course.course}}</p>
                                </div>
                                <table class="table table-nowrap table-centered table-hover mb-0">
                                    <tbody>
                                        <tr v-for="prospectus in prospectuses" v-bind:key="prospectus.id" style="cursor: pointer;" @click="pros(prospectus,course)">
                                            <td>
                                                <i class="bx bxs-circle" :class="[(prospectus.is_completed == 0) ? 'text-warning' : 'text-info']"></i>
                                            </td>
                                            <td>
                                                <h5 class="text-truncate font-size-12 mb-0">Effective School Year {{prospectus.school_year}}</h5>
                                            </td>
                                            <td class="text-right" style="width: 90px;">
                                                <span class="badge badge-bg badge-success" v-if="prospectus.is_active == 1">Active</span>
                                                <span class="badge badge-bg badge-danger"  v-else>Inactive</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="prospectuses.length == 0 && course == ''" class="col-md-10 mx-auto mt-5"> 
                                    <br>
                                    <div class="justify-content-center">
                                        <div class="col-xl-12">
                                            <p class="text-muted text-center font-size-12 mt-4">Please click to choose on the list of courses.</p>
                                        </div>
                                        <center>
                                        <i class='text-muted bx bxs-left-arrow-circle h1'></i>
                                        </center>
                                    </div>
                                </div>
                            </simplebar>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top d-grid" style="margin-bottom: -18px;">
                        <button type="button" @click="newProspectus" class="btn btn-block btn-light btn-sm waves-effect waves-light">Add Prospectus</button>
                    </div>
                </div>
            </div>
        </div>
        <ViewProspectus :height="height" @status="message" ref="prospectus"/>
        <NewCourse @status="message" ref="newCourse" />
        <NewProspectus @status="message" ref="newProspectus" />
        <NewSemester @status="message" :dropdowns="dropdowns" ref="newSemester" />
    </div>

</div>
</template>
<script>
import ViewProspectus from './Prospectus/View.vue'
import NewCourse from './NewCourse.vue';
import NewProspectus from './Prospectus/Create.vue';
import NewSemester from './NewSemester.vue';
import simplebar from 'simplebar-vue';
export default {
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            height: this.$parent.$parent.$parent.$parent.height,
            counts: this.$parent.$parent.$parent.$parent.counts,
            errors: [],
            pagination: {},
            keyword: '',
            id : this.$route.params.id,
            school: {municipality: {}},
            editable : false,
            prospectuses: [],
            semesters: [],
            course: '',
            year: new Date().getFullYear()
        }
    },

    created(){
        this.fetch();
    },

    methods: {
        fetch(){
            axios.get(this.currentUrl + '/request/school/view/'+this.$route.params.id)
            .then(response => {
                this.school = response.data.data;
            })
            .catch(err => console.log(err));
        },

        newCourse(){
            this.editable = 'newcourse';
            this.$refs.newCourse.set(this.school);
            this.$bvModal.show("newCourse");
        },

        newSemester(){
            this.editable = 'newsemester';
            this.$refs.newSemester.set(this.year,this.school.id);
            this.$bvModal.show("newSemester");
        },

        newProspectus(){
            this.editable = 'newprospectus';
            let course = this.course;
            // Vue.delete(course, 'prospectuses');
            this.$refs.newProspectus.set(course);
            this.$bvModal.show("newProspectus");
        },

        view(course){
            this.course = course;
            this.prospectuses = course.prospectuses;
        },

        pros(prospectus,course){
            // Vue.delete(course, 'prospectuses');
            this.editable = 'prospectus';
            this.$refs.prospectus.set(prospectus,course);
            this.$bvModal.show("prospectus");
        },

        message(list){
            if(list){
                if(this.editable == true){
                    let index = this.school.courses.findIndex(u => u.id === list.id);
                    this.$set(this.school.courses, index, list);
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }else if(this.editable == 'newcourse'){
                    this.school.courses.unshift(list);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    this.$bvModal.hide("newCourse");
                }else if(this.editable == 'prospectus'){
                    let index = this.prospectuses.findIndex(u => u.id === list.id);
                    this.$set(this.prospectuses, index, list);
                    Vue.$toast.success('<strong>Prospectus changes saved.</strong>', {
                        position: 'bottom-right'
                    });
                }else if(this.editable == 'newsemester'){
                   this.school.semesters.unshift(list);
                    Vue.$toast.success('<strong>Prospectus changes saved.</strong>', {
                        position: 'bottom-right'
                    });
                     this.$bvModal.hide("newSemester");
                }
                else{
                    this.prospectuses.unshift(list);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    this.$bvModal.hide("newProspectus");
                }
                this.editable = false;
            }
        },

    }, components : { simplebar, NewCourse, NewProspectus, ViewProspectus, NewSemester}
}
</script>