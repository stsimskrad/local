<template>
    <b-modal  @ok="create($event)" id="endorsement" ok-title="Add as Scholar" title="Endorsement" centered>
        <div class="media">
            <div class="align-self-center me-3">
                <img class="rounded avatar-md" :src="currentUrl+'/images/avatars/'+user.information.avatar" alt="">
            </div>
            <div class="media-body">
                <h5 class="font-size-15 mt-0 mb-1 mt-1">
                    {{user.name}}
                </h5>
                <p class="text-muted font-size-11 fw-bold mb-0">{{user.spas_id}}</p>
                <p class="text-muted mb-0"><span class="badge bg-primary">{{ user.information.program_id.name }}</span></p>
            </div>
        </div>
        <hr/>

        <blockquote class="p-3 border-light border rounded">
            <div class="row font-size-12">
                <div class="row font-size-12">
                    <div class="col-sm-12">
                        <h6 class="text-muted font-size-11 mb-0"><i class="bx bxs-map me-1 text-primary"></i>Endorsed By</h6>
                        <p class="fw-bold text-dark mb-0"><span class="fw-bold">{{ user.endorsed_region }}</span>  <span class="text-muted">({{ user.endorsed_name}})</span></p>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <h6 class="text-muted font-size-11 mb-0"><i class="bx bxs-school me-1 text-primary"></i>School</h6>
                        <p class="fw-bold text-dark mb-0">{{user.information.school.name}}</p>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <h6 class="text-muted font-size-11 mb-0"><i class="bx bxs-graduation me-1 text-primary"></i>Course</h6>
                        <p class="fw-bold text-dark mb-0">{{user.information.course.name}}</p>
                    </div>
                </div>
            </div>
        </blockquote>
    </b-modal>
</template>
<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                user: {
                    endorsed_by: {},
                    information: {
                        school: {}, course : {}, program_id: {}, info: { parents : {}}
                    }
                }
            }
        },

        methods : {
            set(data){
                this.user = data;
            },

            create(){
                let data = new FormData();
                let info = JSON.stringify(this.user.information);
                data.append('information', (this.user.information != undefined) ? info : '');
                data.append('email', (this.user.information.email != undefined) ? this.user.information.email : '');
                data.append('firstname', (this.user.information.firstname != undefined) ? this.user.information.firstname : '');
                data.append('lastname', (this.user.information.lastname != undefined) ? this.user.information.lastname : '');
                data.append('middlename', (this.user.information.middlename != undefined) ? this.user.information.middlename : '');
                data.append('suffix', (this.user.information.suffix != undefined) ? this.user.information.suffix : '');
                data.append('gender', (this.user.information.gender != undefined) ? (this.user.information.gender == 'Male') ? 1 : 2 : '');
                data.append('mobile', (this.user.information.mobile != undefined) ? this.user.information.mobile : '');
                data.append('birthday', (this.user.information.birthday != undefined) ? this.user.information.birthday : '');
                data.append('father', (this.user.information.info.parents.father != undefined) ? this.user.information.info.parents.father : '');
                data.append('mother', (this.user.information.info.parents.mother != undefined) ? this.user.information.info.parents.mother : '');
                data.append('lrn', (this.user.information.lrn != undefined) ? (this.user.information.lrn == 'N/A') ? '' : this.user.information.lrn : '');
                data.append('spas_id', (this.user.spas_id != undefined) ? this.user.spas_id : '');
                data.append('course_id', (this.user.information.course != undefined) ? this.user.information.course.id : '');
                data.append('school_id', (this.user.information.school != undefined) ? this.user.information.school.id : '');
                data.append('level_id', (this.user.information.is_undergrad) ? 2 : 4);
                data.append('program_id', (this.user.information.program_id != undefined) ? this.user.information.program_id.id : '');
                data.append('status_id', 30);
                data.append('is_undergrad', (this.user.information.is_undergrad != undefined) ? this.user.information.is_undergrad : '');
                data.append('region_code', (this.user.address.has_region) ? this.user.address.region.code : null);
                data.append('province_code', (this.user.address.has_province) ? this.user.address.province.code : null);
                data.append('municipality_code', (this.user.address.has_municipality) ? this.user.address.municipality.code : null);
                data.append('barangay_code', (this.user.address.has_barangay) ? this.user.address.barangay.code : null);
                data.append('barangay_code', (this.user.address.has_barangay) ? this.user.address.barangay.code : null);
                data.append('editable', 'single');
                
                // data.append('region_code', (this.user.region != undefined) ? this.user.region.code : '');
                // data.append('province_code', (this.user.province != undefined) ? this.user.province.code : '');
                // data.append('municipality_code', (this.user.municipality != undefined) ? this.user.municipality.code : '');
                // data.append('address', (this.user.address != undefined) ? this.user.address : '');

                axios.post(this.currentUrl + '/request/scholar/store', data)
                .then(response => {
                    this.clear();
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    // this.isLoading = false;
                    this.$router.push({ name: 'scholars'})
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
            },

        }
    }
</script>


