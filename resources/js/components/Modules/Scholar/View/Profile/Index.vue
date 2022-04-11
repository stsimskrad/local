<template>
    <div class="col-md-12">
        <blockquote class="p-3 border-light border rounded ">
            <span @click="edit(user)" class="float-end" style="cursor: pointer;"><i class='bx bxs-edit font-size-12'>&nbsp;</i></span>
            <div class="d-flex">
                <div class="me-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-2 text-primary fw-bold">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }} </p>
                </div>
            </div>
            <div class="row font-size-12 mt-3">
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-credit-card me-1 text-primary"></i>SPAS ID no.</h6>
                    <p class="fw-bold text-dark mb-0">{{user.spas_id}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-mail-send me-1 text-primary"></i>Learner's Reference No.</h6>
                    <p class="fw-bold text-dark mb-0">{{user.lrn}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-category me-1 text-primary"></i>Category</h6>
                    <p class="fw-bold text-dark mb-0">{{user.category_id.name}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-calendar me-1 text-primary"></i>Awarded Year</h6>
                    <p class="fw-bold text-dark mb-0">{{user.awarded_year}}</p>
                </div>
                <div class="col-sm-12"><hr></div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-mail-send me-1 text-primary"></i>Email</h6>
                    <p class="fw-bold text-dark mb-0">{{user.email}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-phone me-1 text-primary"></i>Mobile</h6>
                    <p class="fw-bold text-dark mb-0">{{user.mobile}}</p>
                </div>
                 <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-female me-1 text-primary"></i>Mother</h6>
                    <p class="fw-bold text-dark mb-0">{{user.mother}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-male me-1 text-primary"></i>Father</h6>
                    <p class="fw-bold text-dark mb-0">{{user.father}}</p>
                </div>
            </div>
        </blockquote>

        <hr>

        
        <div class="row font-size-12">
            <div class="col-md-6">
                <blockquote class="p-3 border-light border rounded ">
                    <span @click="editSchool" class="float-end" style="cursor: pointer;"><i class='bx bxs-edit font-size-12'>&nbsp;</i></span>
                    <h6 class="card-title text-secondary mb-0 font-size-12">Education</h6>
                    <hr>
                    <div class="row font-size-12 mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted font-size-11 mb-0"><i class="bx bxs-school me-1 text-primary"></i>School</h6>
                            <p class="fw-bold text-dark mb-0">{{user.school.school.name}} - <span class="text-muted">{{user.school.campus}}</span></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted font-size-11 mb-0"><i class="bx bxs-graduation me-1 text-primary"></i>Course</h6>
                            <p class="fw-bold text-dark mb-0">{{user.course.name}}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted font-size-11 mb-0"><i class="bx bxs-calendar me-1 text-primary"></i>Year level</h6>
                            <p class="fw-bold text-dark mb-0">{{user.level.name}} Year</p>
                        </div>
                    </div>
                </blockquote>
            </div>
             <div class="col-md-6">
                <blockquote class="p-3 border-light border rounded ">
                    <span @click="editAddress" class="float-end" style="cursor: pointer;"><i class='bx bxs-edit font-size-12'>&nbsp;</i></span>
                    <h6 class="card-title text-secondary mb-0 font-size-12">Address</h6>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-map me-1 text-primary"></i>Region</h6>
                            <p class="fw-bold text-dark mb-0">{{user.region.region}} ({{ user.region.name }})</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-map-alt me-1 text-primary font-size-15"></i>Province</h6>
                            <p class="fw-bold text-dark mb-0">{{ user.province.name }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted font-size-11 mb-0"><i class="bx bx-sitemap me-1 text-primary"></i>Municipality</h6>
                            <p class="fw-bold text-dark mb-0"> {{ user.municipality.name }}</p>
                        </div>
                    </div>
                </blockquote>
            </div>
        </div> 

        <School :dropdowns="dropdowns" ref="school" />
        <Address ref="address" />
        <!-- <div class="modal fade exampleModal" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <profile-edit @status="status" :user="user" ref="profile"></profile-edit>
        </div> -->

        <!-- <div class="modal fade exampleModal" id="editSchool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <profile-school-edit @status="status" ref="school"></profile-school-edit>
        </div>

        <div class="modal fade exampleModal" id="editAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <profile-address-edit @status="status" ref="address"></profile-address-edit>
        </div> -->

    </div>
</template>
<script>
    import School from './EditSchool.vue';
    import Address from './EditAddress.vue';
    export default {
        props: ['dropdowns'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                user: {
                    category_id : {}
                },
                editable: ''
            }
        },
        created(){
            this.user = this.$route.params.data;
        },  

        methods : {
            edit(){
                $("#editProfile").appendTo("body").modal('show');
            },

            editSchool(){
                this.$bvModal.show("updateSchool");
                this.$refs.school.set(this.user);
                this.editable = 'school';
            },

            editAddress(){
                this.$bvModal.show("updateAddress");
                this.$refs.address.set(this.user);
                this.editable = 'address';
            },

            status(list){
                if(list){
                    if(this.editable == 'address'){
                        this.user = list;
                        $("#editAddress").modal('hide');
                    }else{  
                        this.user = list;
                       $("#editSchool").modal('hide');
                    }
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                    this.editable = '';
                }
            }
        }, components : { School , Address }
    }
</script>