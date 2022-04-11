<template>
    <b-modal @ok="save($event)" id="research" size="lg" ok-title="Save" title="Research" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title of Research: <span v-if="errors.research" class="haveerror">({{ errors.research[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="research" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Source of fund: <span v-if="errors.fund" class="haveerror">({{ errors.fund[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="fund" style="text-transform: capitalize;">
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nature of Involvement: <span v-if="errors.involvement" class="haveerror">({{ errors.involvement[0] }})</span></label>
                        <input type="text" class="form-control" v-model="involvement" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Duration: <span v-if="errors.duration" class="haveerror">({{ errors.duration[0] }})</span></label>
                        <input type="text" class="form-control" v-model="duration">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Location: <span v-if="errors.location" class="haveerror">({{ errors.location[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="location" style="text-transform: capitalize;">
                    </div>
                </div> 
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        props: ['user'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                id: '',
                research: '',
                involvement: '',
                duration: '',
                fund: '',
                location: ''
            }
        },

        methods : {
            save(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/scholar/tracer/store', {
                    id: this.id,
                    user: this.user,
                    research: this.research,
                    fund: this.fund,
                    involvement: this.involvement,
                    duration: this.duration,
                    location: this.location,
                    type: 'Research'
                })
                .then(response => {
                    this.empty();
                    this.$emit('status',response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            empty(){
                this.research = '';
                this.fund = '';
                this.involvement = '';
                this.duration = '';
                this.location = '';
                this.errors = [];
            }
        }
    }
</script>


