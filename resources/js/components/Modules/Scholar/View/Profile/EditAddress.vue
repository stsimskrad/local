<template>
    <b-modal @ok="save($event)" id="updateAddress" ok-title="Save" title="Edit Address" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Region: <span v-if="errors.region" class="haveerror">({{( errors.region[0] )}})</span></label>
                            <multiselect 
                            @input="onChangeRegion(region.code)"
                            v-model="region" 
                            :options="regions"
                            :allow-empty="false"
                            :show-labels="false"
                            label="region" track-by="code"
                            placeholder="Select Region">
                        </multiselect>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Province: <span v-if="errors.province" class="haveerror">({{( errors.province[0] )}})</span></label>
                            <multiselect 
                            @input="onChangeProvince(province.code)"
                            v-model="province" 
                            :options="provinces"
                            :allow-empty="false"
                            :show-labels="false"
                            label="name" track-by="code"
                            placeholder="Select Province">
                        </multiselect>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Municipality: <span v-if="errors.municipality" class="haveerror">({{( errors.municipality[0] )}})</span></label>
                            <multiselect 
                            v-model="municipality" 
                            :options="municipalities"
                            :allow-empty="false"
                            :show-labels="false"
                            label="name" track-by="code"
                            placeholder="Select Municipality">
                        </multiselect>
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
                id: '',
                regions: [],
                provinces: [],
                municipalities: [],
                region: '',
                province: '',
                municipality: '',
            }
        },

        methods : {
            set(user){
                this.id = user.id;
                this.region = user.region;
                this.province = user.province;
                this.municipality = user.municipality;
                this.fetchRegion();
                this.fetchProvince(user.region.code);
                this.fetchMunicipality(user.province.code);
            },

            fetchRegion(){
                axios.get(this.currentUrl + '/lists/regions')
                .then(response => {
                    this.regions = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchProvince($id){
                axios.get(this.currentUrl + '/lists/provinces/'+$id)
                .then(response => {
                    this.provinces = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchMunicipality($id){
                axios.get(this.currentUrl + '/lists/municipalities/'+$id)
                .then(response => {
                    this.municipalities = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChangeRegion($id) {
                this.fetchProvince($id);
                this.province = '';
                this.municipality = '';
            },

            onChangeProvince($id) {
                this.fetchMunicipality($id);
                this.municipality = '';
            },

            save(){
                axios.post(this.currentUrl + '/request/scholar/store', {
                    scholar_id: this.id,
                    municipality_code: this.municipality.code,
                    editable: 'address'
                })
                .then(response => {
                     this.$emit('status',response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }

        }, components : {Multiselect}
    }
</script>


