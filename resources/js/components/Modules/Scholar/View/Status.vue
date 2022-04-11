<template>
    <b-modal id="updateStatus" hide-footer title="Update Status" no-close-on-backdrop centered>
        <form @submit.prevent="save" class="customform">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Status: <span v-if="errors.status" class="haveerror">({{ errors.status[0] }})</span></label>
                        <multiselect 
                            v-model="status" 
                            :options="options" 
                            group-values="libs" group-label="language"
                            :show-labels="false"
                            label="name" track-by="id" 
                            :allow-empty="false"
                            placeholder="Select Status">
                        </multiselect>
                    </div>
                </div>
                <div class="col-md-12" v-if="status">
                    <hr style="height: .8px;">
                    <p class="text-center fs-11 text-muted">Please type "CONFIRM" to continue</p>
                    <div class="form-group">
                        <input type="text" class="form-control text-center"  v-model="confirm">
                    </div>
                </div> 
                <div class="col-md-12 d-inline-block mt-2" v-if="status">
                    <button type="submit" class="btn btn-info btn-sm w-lg float-end waves-effect waves-light mb-4" :disabled="(confirm == 'CONFIRM') ? false : true">UPDATE</button>
                </div>
            </div>
        </form>
    </b-modal>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                id: '',
                status: '',
                statuses: '',
                confirm: '',
                options: [{language: 'Ongoing',libs: []},{language: '',libs: []}],
                selected: []
            }
        },

        created(){
            this.fetchLists();
        },

        methods : {
             fetchLists(){
                axios.get(this.currentUrl + '/lists')
                .then(response => {
                    this.statuses = response.data.dropdowns.filter(x => x.classification === 'Status');
                    this.options[0].libs = this.statuses.filter(x => x.type === 'ongoing');
                    this.options[1].libs = this.statuses.filter(x => x.type != 'ongoing');
                })
                .catch(err => console.log(err));
            },

            set(id,status){
                this.id = id;
                this.status = status;
            },

            many(selected){
                this.selected = selected;
            },

            save(){
                if(this.selected.length > 0){
                    this.massUpdate();
                }else{
                    this.soloUpdate();
                }
            },

            soloUpdate(){
                axios.post(this.currentUrl + '/request/scholar/store', {
                    id: this.id,
                    status_id: this.status.id,
                    editable: true
                })
                .then(response => {
                    this.$emit('status',this.status);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            massUpdate(){
                axios.post(this.currentUrl + '/request/scholar/status', {
                    selected: this.selected,
                    status_id: this.status.id,
                })
                .then(response => {
                    this.$emit('status',this.status);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            clear(){
                this.editable = false;
                this.confirm = '';
                this.$bvModal.hide("updateStatus");
                Vue.$toast.success('<strong>Successfully Updated</strong>', {
                    position: 'bottom-right'
                });
            }
        }, components : {Multiselect}
    }
</script>
