<template>
    <b-modal @ok="create($event)" id="newCourse" ok-title="Confirm" title="New Course" centered>
        <b-form class="customform mb-2">
            <div class="row">
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
                    <div class="form-group">
                        <label>Type: <span v-if="errors.type" class="haveerror">({{( errors.type[0] )}})</span></label>
                        <input type="text" class="form-control" v-model="type" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Years: <span v-if="errors.years" class="haveerror">({{( errors.years[0] )}})</span></label>
                        <input type="text" class="form-control" v-model="years" style="text-transform: capitalize;">
                    </div>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                courses: [],
                course: '',
                type: '',
                years:'',
                school: {},
                editable: false
            }
        },

        methods : {
            set(data){
                this.school = data;
            },

            asyncCourse(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/request/search/courses', {
                        word: value,
                    })
                    .then(response => {
                        this.courses = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            create(evt){
                evt.preventDefault();
                let data = new FormData();
                data.append('school_id', (this.school.id != undefined) ? this.school.id : '');
                data.append('course_id', (this.course.id != undefined) ? this.course.id : '');
                (this.type != '') ? data.append('type', this.type) : '';
                data.append('years', this.years);
                data.append('editable', this.editable);

                axios.post(this.currentUrl + '/request/school/course/store', data)
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.type = '';
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
        }, components : { Multiselect}
    }
</script>







