<template>
    <b-modal @ok="save($event)" id="history" size="lg" ok-title="Save" title="History" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Company: <span v-if="errors.company" class="haveerror">({{ errors.company[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="company" style="text-transform: capitalize;">
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
                        <input type="text" class="form-control"  v-model="position" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Period: <span v-if="errors.period" class="haveerror">({{ errors.period[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="period" style="text-transform: capitalize;" placeholder="January 2020 - January 2021">
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="alert alert-warning alert-dismissible fade show align-middle" role="alert">
                        <b-form-checkbox v-model="job" unchecked-value="not_accepted" checked plain style="font-size: 15px;">
                            Is Job Related To Undergraduate Academic Training?
                        </b-form-checkbox>
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
                company: '',
                address: '',
                position: '',
                period: '',
                job: false
                
            }
        },

        methods : {
            save(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/scholar/tracer/store', {
                    id: this.id,
                    user: this.user,
                    company: this.company,
                    address: this.address,
                    position: this.position,
                    period: this.period,
                    job: this.job,
                    type: 'History'
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
                this.company = '';
                this.address = '';
                this.position = '';
                this.period = '';
                this.errors = [];
            }
        }
    }
</script>


