<template>
    <b-modal @ok="save($event)" id="affliation" size="lg" title="Affliation" ok-title="Save" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Organization: <span v-if="errors.organization" class="haveerror">({{ errors.organization[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="organization" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address: <span v-if="errors.address" class="haveerror">({{ errors.address[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="address" style="text-transform: capitalize;">
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Position: <span v-if="errors.position" class="haveerror">({{ errors.position[0] }})</span></label>
                        <input type="text" class="form-control" v-model="position" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Duration: <span v-if="errors.duration" class="haveerror">({{ errors.duration[0] }})</span></label>
                        <input type="text" class="form-control" v-model="duration" style="text-transform: capitalize;">
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
                organization: '',
                address: '',
                position: '',
                duration: ''
            }
        },

        methods : {
            save(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/scholar/tracer/store', {
                    id: this.id,
                    user: this.user,
                    organization: this.organization,
                    address: this.address,
                    position: this.position,
                    duration: this.duration,
                    type: 'Affliation'
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
                this.organization = '';
                this.duration = '';
                this.position = '';
                this.address = '';
                this.errors = [];
            }
        }
    }
</script>


