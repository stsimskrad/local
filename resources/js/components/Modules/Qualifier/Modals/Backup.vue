<template>
    <b-modal id="add" hide-footer title="Confirm Scholar" centered>
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
                    editable: 'qualifier'
                })
                .then(response => {
                    this.$emit('status', this.user);
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





