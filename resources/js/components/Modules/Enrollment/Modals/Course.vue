<template>
    <b-modal @ok="save($event)"  id="course" title="Update Course" ok-title="Save" no-close-on-backdrop centered>
        <form @submit.prevent="save" class="customform">
            <div class="row mt-2">
                <div class="col-md-12 mb-n2" v-if="profile != '' && school != '' && course != ''">
                     <div class="d-flex">
                        <div class="me-3">
                            <img :src="currentUrl+'/images/avatars/'+profile.avatar" alt=""
                                class="avatar-sm rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-grow-1 align-self-center">
                            <div class="text-muted">
                                <p class="text-primary font-size-15 fw-bold mb-0">
                                    {{ profile.firstname }}
                                    {{ profile.middlename[0] }}.
                                    {{ profile.lastname}} {{ profile.suffix}}
                                </p>
                                <p class="font-size-11 mt-n1 mb-0">{{school.name}}</p>
                                <p class="font-size-11 fw-bold mt-n1">{{course.name.toUpperCase() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="">
                    <label>Subcourse: <span v-if="errors.course_id" class="haveerror">({{ errors.course_id[0] }})</span></label>
                    <multiselect v-model="subcourse" id="ajax" label="type" track-by="id"
                        placeholder="Select Course" open-direction="bottom" 
                        :options="subcourses"
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
            </div>
        </form>
    </b-modal>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        components: { Multiselect },
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                courses: [],
                subcourses: [],
                subcourse: '',
                course: '',
                profile: '',
                id: '',
            }
        },

        methods: {
            set(id,profile,school,course){
                this.profile = profile;
                this.school = school;
                this.course = course;
                this.id = id;
                this.fetchSubcourse();
            },

            fetchSubcourse(){
                axios.get(this.currentUrl + '/request/school/subcourses/'+this.school.id+'/'+this.course.id)
                .then(response => {
                    this.subcourses = response.data;
                })
                .catch(err => console.log(err));
            },
            
            save(){
                axios.post(this.currentUrl + '/request/scholar/store', {
                    id: this.id,
                    subcourse_id: this.subcourse.id,
                    editable: 'course'
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }
        }
    }
</script>

<style>
    .modal-header .close {
        display: none;
    }

</style>
