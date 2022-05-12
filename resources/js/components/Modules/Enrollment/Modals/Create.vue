<template>
    <b-modal @ok="save($event)" id="create" title="Enrollment" ok-title="Save" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-success mt-2 mb-n1">
                        Are you sure you want to enroll the scholar?
                    </div>
                    <div class="form-check" v-if="enrollments.lenght > 0">
                        <input class="form-check-input" type="checkbox" id="gridCheck"/>
                        <label class="form-check-label" for="gridCheck">Do you want to update status?</label>
                    </div>
                    <div class="form-check" v-if="class_type == 'Private'">
                        <input class="form-check-input" type="checkbox" id="gridCheck"/>
                        <label class="form-check-label" for="gridCheck">Do you want to add Tuition fee?</label>
                    </div>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                value: '',
                enrollments: [],
                class_type: ''
            }
        },

        created(){
            this.enrollments = this.user.enrollments;
            this.class_type = this.user.education.school.class;
        },

        methods: {
            set(value){
                this.value = value;
            },

            save(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/evaluation/enrollment/store',this.value)
                .then(response => {
                    this.$emit('status', response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.$emit('err', this.errors);
                    }else if (error.response.status == 500) {
                        Vue.$toast.error('<strong>Please contact Administrator</strong>', {
                            position: 'bottom-right'
                        });
                    }
                });
            },
        }
    }
</script>
