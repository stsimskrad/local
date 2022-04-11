<template>
    <b-modal id="warning" hide-footer title="Remarks" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-2 fw-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }}</p>
                </div>
            </div>
            <div class="row font-size-11 mt-3">
                <div class="col-sm-12">
                    <h6 class="text-muted font-size-12"><i class="bx bxs-file-doc mr-1 text-primary"></i>Lacking</h6>
                    <p class="font-weight-bold text-dark mb-0">{{(user.info.requirements.lacking == null) ? 'Not Available' : user.info.requirements.lacking}}</p>
                </div>
                <!-- <div class="col-sm-6">
                    <h6 class="text-muted font-size-12"><i class="bx bx-notepad mr-1 text-primary"></i>Remarks</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.info.requirements.remarks}}</p>
                </div> -->
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
                    info : {
                        requirements: {}
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


