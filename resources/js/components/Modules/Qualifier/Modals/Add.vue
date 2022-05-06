<template>
    <b-modal id="add" size="lg" hide-footer title="Confirm Scholar" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-1 fw-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }} <span class="text-muted font-size-11 ml-2">({{user.program_id.name}})</span> </p>
                </div>
            </div>
            <div class="row font-size-11 mt-2">
                <div class="col-sm-12">
                    <p class="fw-bold text-danger mb-0">{{user.barangay}}, {{user.municipality}}, {{user.province}}</p>
                    <p class="fw-bold text-dark mb-0">{{user.school}}</p>
                    <p class="text-dark mb-0">{{user.course}}</p>
                </div>
            </div>
        </blockquote>

        <form @submit.prevent="submit" class="customform">
            <div class="row customerform" style="margin-right: 5px; margin-left: 5px;">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
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
                        <div class="col-md-6">
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
                </div>
                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-info btn-sm btn-block waves-effect waves-light mb-4">COMFIRM SCHOLAR</button>
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
                user: {
                    program_id: {}
                },
                profile_id : '',
                lrn: '',
                program_id: '',
                schools: [],
                courses: [],
                level: '',
                school: '',
                course: '',
                provinces: [],
                municipalities: [],
                barangays: [],
                region: '',
                province: '',
                municipality: '',
                barangay: ''
            }
        },

        computed:{
            levels : function() {
              return this.dropdowns.filter(x => x.classification === 'Level');
            }
        },
        methods : {
            set(data){
                this.user = data;
            },

            submit(){
                axios.post(this.currentUrl + '/request/scholar/store', {
                    qualifier_id: this.user.id,
                    spas_id: this.user.spas_id,
                    profile_id: this.user.profile_id,
                    program_id: this.user.program_id.id,
                    is_undergrad: this.user.is_undergrad,
                    status_id : 30,
                    is_completed: 0,
                    email: this.user.email,
                    awarded_year: new Date().getFullYear(),
                    address : this.user.info.address.street,
                    region_code: (this.region != '') ? this.region.code : '',
                    province_code: (this.province != '') ? this.province.code : '',
                    municipality_code: (this.municipality != '') ? this.municipality.code : '',
                    barangay_code: (this.barangay != '') ? this.barangay.code : '',
                    editable: 'qualifier'
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

            asyncSchool(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/search/schools', {
                        word: value,
                    })
                    .then(response => {
                        this.schools = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            asyncCourse(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/search/courses', {
                        word: value,
                    })
                    .then(response => {
                        this.courses = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
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
                this.awarded_year = '';
                this.region = '';
                this.province = '';
                this.municipality = '';
                this.barangay = '';
                this.school = '';
                this.course = '';
                this.$bvModal.hide("add");
            }
            
        }, components : { Multiselect }
    }
</script>





