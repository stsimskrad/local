<template>
    <b-modal @ok="save($event)" id="award" size="lg" title="Award" ok-title="Save"  centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title of Award: <span v-if="errors.award" class="haveerror">({{ errors.award[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="award" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Awarding Body: <span v-if="errors.body" class="haveerror">({{ errors.body[0] }})</span></label>
                        <input type="text" class="form-control"  v-model="body" style="text-transform: capitalize;">
                    </div>
                </div> 
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Date: <span v-if="errors.given" class="haveerror">({{ errors.given[0] }})</span></label>
                        <input type="date" class="form-control" v-model="given" style="text-transform: capitalize;">
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
                award: '',
                body: '',
                given: ''
            }
        },

        methods : {
            save(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/scholar/tracer/store', {
                    id: this.id,
                    user: this.user,
                    award: this.award,
                    body: this.body,
                    given: this.given,
                    type: 'Award'
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
                this.award = '';
                this.body = '';
                this.given = '';
                this.errors = [];
            }
        }
    }
</script>


