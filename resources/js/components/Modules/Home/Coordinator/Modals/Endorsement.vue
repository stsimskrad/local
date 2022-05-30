<template>
    <b-modal id="endorsement" ok-title="Add as Scholar" title="Endorsement" centered>
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

        <blockquote class="p-3 border-light border rounded ">
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
                        school: {}, course : {}, program_id: {}
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


