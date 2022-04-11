<template>
    <b-modal id="referral" hide-footer title="Refer Scholar" centered>
        <blockquote class="p-3 border-light border rounded">
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-2 fw-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }}</p>
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