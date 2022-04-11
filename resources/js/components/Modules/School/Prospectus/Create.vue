<template>
    <b-modal @ok="create($event)" id="newProspectus" ok-title="Confirm" title="New Prospectus" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>School Year: <span v-if="errors.school_year" class="haveerror">({{( errors.school_year[0] )}})</span></label>
                        <input type="text" class="form-control" v-model="schoolyear">
                    </div>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                schoolyear: '',
                course: '',
                editable: false,
            }
        },

        methods : {
            set(data){
                this.course = data;
            },

            create(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/prospectus/store',{
                    school_course_id : this.course.id,
                    years : this.course.years,
                    school_year: this.schoolyear,
                    editable: false
                })
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
        },
    }
</script>


