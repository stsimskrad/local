<template>
    <b-modal id="update" hide-footer title="Update Scholar" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-1 fw-bold text-primary">{{ user.profile.lastname}}, {{ user.profile.firstname}} {{ user.profile.middlename }} <span class="text-muted font-size-11 ml-2">({{user.category.name}})</span> </p>
                </div>
            </div>
            <div class="row font-size-11 mt-2">
                <div class="col-sm-12">
                    <p class="fw-bold text-danger mb-0">{{user.address.name.toUpperCase()}}</p>
                    <p class="fw-bold text-dark mb-0">{{ (user.education.school != 'n/a') ? user.education.school.name : user.education.school}}</p>
                    <p class="text-dark mb-0">{{user.education.course }} </p>
                </div>
            </div>
        </blockquote>

        <form @submit.prevent="submit" class="customform">
            <div class="row customerform">
                <div class="col-md-12" v-if="!user.education.has_school">
                    <label>School: <span v-if="errors.school_id" class="haveerror">({{ errors.school_id[0] }})</span></label>
                    <multiselect v-model="school" id="ajax" label="name" track-by="id"
                        placeholder="Search School" open-direction="bottom" :options="schools"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false"
                        @search-change="asyncSchool">
                    </multiselect> 
                </div>
                <div class="col-md-12" v-if="!user.education.has_course">
                    <label>Course: <span v-if="errors.course_id" class="haveerror">({{ errors.course_id[0] }})</span></label>
                    <multiselect v-model="course" id="ajax" label="name" track-by="id"
                        placeholder="Search Course" open-direction="bottom" :options="courses"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false"
                        @search-change="asyncCourse">
                    </multiselect> 
                </div>
                <div class="col-md-12" v-if="!user.education.has_level">
                    <label>Level: <span v-if="errors.level_id" class="haveerror">({{ errors.level_id[0] }})</span></label>
                    <multiselect 
                        v-model="level" 
                        id="ajax" 
                        label="name" track-by="id"
                        placeholder="Search Level" 
                        open-direction="bottom" 
                        :options="levels"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <label>School: <span v-if="errors.school_id" class="haveerror">({{ errors.school_id[0] }})</span></label>
                            <multiselect v-model="school" id="ajax" label="name" track-by="id"
                                placeholder="Search School" open-direction="bottom" :options="schools"
                                :searchable="true" 
                                :allow-empty="false"
                                :show-labels="false"
                                @search-change="asyncSchool">
                            </multiselect> 
                        </div>
                        <div class="col-md-12">
                            <label>Course: <span v-if="errors.course_id" class="haveerror">({{ errors.course_id[0] }})</span></label>
                            <multiselect v-model="course" id="ajax" label="name" track-by="id"
                                placeholder="Search Course" open-direction="bottom" :options="courses"
                                :searchable="true" 
                                :allow-empty="false"
                                :show-labels="false"
                                @search-change="asyncCourse">
                            </multiselect> 
                        </div>
                        <div class="col-md-12">
                            <label>Level: <span v-if="errors.level_id" class="haveerror">({{ errors.level_id[0] }})</span></label>
                            <multiselect 
                                v-model="level" 
                                id="ajax" 
                                label="name" track-by="id"
                                placeholder="Search Level" 
                                open-direction="bottom" 
                                :options="levels"
                                :searchable="true" 
                                :allow-empty="false"
                                :show-labels="false">
                            </multiselect> 
                        </div>
                    </div>    -->
                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-info btn-sm btn-block waves-effect waves-light mb-4">UPDATE SCHOLAR</button>
                </div>
            </div>
        </form>
    </b-modal>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['dropdowns','regions'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                user: {
                    category: {},
                    profile: {},
                    address: {name: ''},
                    status: {},
                    education: {school: ''},
                    course: {}
                },
                profile_id : '',
                lrn: '',
                category_id: '',
                schools: [],
                courses: [],
                level: '',
                school: '',
                course: '',
                provinces: [],
                municipalities: [],
                region: '',
                province: '',
                municipality: ''
            }
        },

        computed:{
            levels : function() {
              return this.dropdowns.filter(x => x.classification === 'Level');
            }
        },
        methods : {
            set(data){
                this.user = data;
            },

            submit(){
                let data = new FormData();

                data.append('id', this.user.id);
                data.append('is_completed', 1);
                data.append('type', 'old');
                data.append('editable', 'true');
                
                (!this.user.education.has_school) ? data.append('school_id',(this.school != '') ? this.school.id : '') : '';
                (!this.user.education.has_course) ? data.append('course_id', (this.course != '') ? this.course.id : '') : '';
                (!this.user.education.has_level) ? data.append('level_id', (this.level != '') ? this.level.id : '') : '';


                axios.post(this.currentUrl + '/request/scholar/store', data)
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.isLoading = false;
                    }else{
                        this.errors = [];
                    }
                    
                });
            },

            asyncSchool(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/search/schools', {
                        word: value,
                    })
                    .then(response => {
                        this.schools = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            asyncCourse(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/search/courses', {
                        word: value,
                    })
                    .then(response => {
                        this.courses = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            fetchProvince($id){
                axios.get(this.currentUrl + '/lists/provinces/'+$id)
                .then(response => {
                    this.provinces = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchMunicipality($id){
                axios.get(this.currentUrl + '/lists/municipalities/'+$id)
                .then(response => {
                    this.municipalities = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChangeRegion($id) {
                this.fetchProvince($id);
                this.province = '';
                this.municipality = '';
            },

            onChangeProvince($id) {
                this.fetchMunicipality($id);
                this.municipality = '';
            },

            clear(){
                this.awarded_year = '';
                this.region = '';
                this.province = '';
                this.municipality = '';
                this.school = '';
                this.course = '';
                this.$bvModal.hide("update");
            }
            
        }, components : { Multiselect }
    }
</script>





