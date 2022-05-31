<template>
    <b-modal id="address" @ok="save($event)" ok-title="Update" title="Update Scholar Address" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-1 fw-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.name }} <span class="text-muted font-size-11 ml-2">({{user.program.name}})</span> </p>
                </div>
            </div>
            <div class="row font-size-11 mt-2">
                <div class="col-sm-12">
                    <p class="fw-bold text-danger mb-0">{{user.address.name}}</p>
                    <p class="fw-bold text-dark mb-0">{{user.school}}</p>
                    <p class="text-dark mb-0">{{user.course}}</p>
                </div>
            </div>
        </blockquote>

        <form @submit.prevent="submit" class="customform">
            <div class="row customerform">
                <div class="col-md-12" v-if="!user.address.has_region">
                    <div class="form-group">
                        <label>Region: <span v-if="errors.region_code" class="haveerror">({{( errors.region_code[0] )}})</span></label>
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
                <div class="col-md-12" v-if="!user.address.has_province">
                    <div class="form-group">
                        <label>Province: <span v-if="errors.province_code" class="haveerror">({{( errors.province_code[0] )}})</span></label>
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
                <div class="col-md-12" v-if="!user.address.has_municipality">
                    <div class="form-group" >
                        <label>Municipality: <span v-if="errors.municipality_code" class="haveerror">({{( errors.municipality_code[0] )}})</span></label>
                            <multiselect 
                            v-model="municipality" 
                            @input="onChangeMunicipality(municipality.code)"
                            :options="municipalities"
                            :allow-empty="false"
                            :show-labels="false"
                            label="name" track-by="code"
                            placeholder="Select Municipality">
                        </multiselect>
                    </div>
                </div>
                <div class="col-md-12" v-if="!user.address.has_barangay">
                    <div class="form-group">
                        <label>Barangay: <span v-if="errors.barangay_code" class="haveerror">({{( errors.barangay_code[0] )}})</span></label>
                            <multiselect 
                            v-model="barangay" 
                            :options="barangays"
                            :allow-empty="false"
                            :show-labels="false"
                            label="name" track-by="code"
                            placeholder="Select Barangay">
                        </multiselect>
                    </div>
                </div>
            </div>
        </form>
    </b-modal>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['dropdowns','regions'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                user: {program: {}, address: {}},
                provinces: [],
                municipalities: [],
                barangays: [],
                region: '',
                province: '',
                municipality: '',
                barangay: ''
            }
        },

        methods : {
            set(data){
                this.user = data;
                if(this.user.address.has_region){
                    this.region = this.user.address.region;
                    this.onChangeProvince(this.region.code);
                }
                if(this.user.address.has_province){
                    this.province = this.user.address.province;
                    this.onChangeMunicipality(this.province.code);
                }
                if(this.user.address.has_municipality){
                    this.municipality = this.user.address.municipality;
                    this.fetchBarangay(this.municipality.code);
                }
            },

            save(){
                axios.post(this.currentUrl + '/request/qualifiers/store', {
                    id: this.user.address.id,
                    qualifier_id: this.user.id,
                    region_code: (this.region != '') ? this.region.code : '',
                    province_code: (this.province != '') ? this.province.code : '',
                    municipality_code: (this.municipality != '') ? this.municipality.code : '',
                    barangay_code: (this.barangay != '') ? this.barangay.code : '',
                    is_completed: 1,
                    editable: 'address'
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                         this.isLoading = false;
                    }
                });
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

            fetchBarangay($id){
                axios.get(this.currentUrl + '/lists/barangays/'+$id)
                .then(response => {
                    this.barangays = response.data.data;
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

            onChangeMunicipality($id) {
                this.fetchBarangay($id);
                this.barangay = '';
            },

            clear(){
                this.region = '';
                this.province = '';
                this.municipality = '';
                this.barangay = '';
                this.$bvModal.hide("address");
            }
            
        }, components : { Multiselect }
    }
</script>





