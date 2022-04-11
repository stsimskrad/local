<template>
    <b-modal id="profile" size="lg" hide-footer title="Profile" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-2"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-2 fw-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }} <span class="text-muted font-size-11 ml-2">(SPAS ID: {{user.spas_id}})</span> </p>
                </div>
            </div>
            <div class="row font-size-11 mt-3">
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-list-ul me-1 text-primary"></i>Category</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.category_id.name}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-calendar me-1 text-primary"></i>Birthday</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.birthday}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-phone me-1 text-primary"></i>Mobile</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.mobile}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-mail-send me-1 text-primary"></i>Email</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.email}}</p>
                </div>
                <div class="col-sm-12"><hr></hr></div>
                <div class="col-sm-6">
                    <h6 class="text-muted font-size-12"><i class="bx bxs-school me-1 text-primary"></i>Education</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.school}}</p>
                    <p class="text-muted mb-0">{{user.course}}</p>
                </div>
                <div class="col-sm-6">
                    <h6 class="text-muted font-size-12"><i class="bx bxs-map me-1 text-primary"></i>Address</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.info.address.name}}</p>
                    <p class="text-muted mb-0">{{user.info.address.name2}}</p>
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
                    category_id : {},
                    info : {
                        requirements: {},
                        address: {}
                    }
                }
            }
        },

        methods : {
            set(data){
                this.user = data;
            }
        }
    }
</script>


