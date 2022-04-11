<template>
    <b-modal @ok="save($event)" id="updateSchool" ok-title="Save" title="Edit School" centered>
        <b-form class="customform mb-2">
            <div class="row">
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
                    <label>Year: <span v-if="errors.level_id" class="haveerror">({{ errors.level_id[0] }})</span></label>
                    <multiselect v-model="level" id="ajax" 
                        placeholder="Search Level" 
                        open-direction="bottom" 
                        label="name" track-by="id"
                        :options="levels"
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['dropdowns'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                id: '',
                schools: [],
                courses: [],
                school: '',
                course: '',
                level: ''
            }
        },

       computed:{
            levels : function() {
                return this.dropdowns.filter(x => x.classification === 'Level');
            }
        },

        methods : {
            set(user){
                this.id = user.id;
                this.school = user.skool;
                this.course = user.course;
                this.level = user.level;
            },

            asyncSchool(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/schools', {
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
                    axios.post(this.currentUrl + '/lists/courses', {
                        word: value,
                    })
                    .then(response => {
                        this.courses = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            save(){
                axios.post(this.currentUrl + '/request/scholar/store', {
                    id: this.id,
                    school_id: this.school.id,
                    course_id: this.course.id,
                    level_id: this.level.id,
                    editable: true
                })
                .then(response => {
                     this.$emit('status',response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }

        }, components : {Multiselect}
    }
</script>


