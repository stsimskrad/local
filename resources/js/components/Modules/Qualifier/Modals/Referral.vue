<template>
    <b-modal  @ok="save($event)" id="referral"  title="Endorse Scholar"  ok-title="Endorse" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-2 fw-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }}</p>
                </div>
            </div>
        </blockquote> 
        <div class="customform">
            <div class="form-group">
                <label>School: <span v-if="errors.school_id" class="haveerror">({{ errors.school_id[0] }})</span></label>
                <multiselect v-model="user.school" id="ajax" label="name" track-by="id"
                    placeholder="Search School" open-direction="bottom" :options="schools"
                    :searchable="true" 
                    :allow-empty="false"
                    :show-labels="false"
                    @search-change="asyncSchool">
                </multiselect> 
            </div>
            <div class="form-group">
                <label>Course: <span v-if="errors.course_id" class="haveerror">({{ errors.course_id[0] }})</span></label>
                <multiselect v-model="user.course" id="ajax" label="name" track-by="id"
                    placeholder="Search Course" open-direction="bottom" :options="courses"
                    :searchable="true" 
                    :allow-empty="false"
                    :show-labels="false"
                    @search-change="asyncCourse">
                </multiselect> 
            </div>
        </div>
    </b-modal>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        components : { Multiselect },
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                schools: [],
                courses: [],
                user: {
                    info : {
                        requirements: {}
                    },
                    school : '',
                    course: ''
                }
            }
        },

        methods : {
            set(data){
                this.user = data;
            },
            save(){
                axios.post(this.currentUrl + '/request/endorsement/store', {
                    id: this.user.id,
                    information: this.user,
                    school_id: this.user.school.id,
                    course_id: this.user.course.id,
                    spas_id: this.user.spas_id,
                    name: this.user.lastname+', '+this.user.firstname+' '+this.user.middlename
                })
                .then(response => {
                    this.$emit('status', this.user);
                    this.$bvModal.hide("referral");
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.message;
                        Vue.$toast.error('<strong>'+response.message.data.message+'</strong>', {
                            position: 'bottom-right'
                        });
                    }else{
                        Vue.$toast.error('<strong>'+error.response.data.message+'</strong>', {
                            position: 'bottom-right'
                        });
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

        }
    }
</script>