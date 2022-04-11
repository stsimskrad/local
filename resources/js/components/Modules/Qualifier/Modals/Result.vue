<template>
    <b-modal id="result" hide-footer title="Sync" no-close-on-backdrop centered>
        <center>We found <span class="font-weight-bold text-danger mb-4">{{ users.length }}</span> qualifiers available to sync.</center>
        <center><button type="button" @click="view" class="mt-4 mb-4 btn btn-warning w-md waves-effect waves-light">View Qualifiers</button></center>
    </b-modal>
</template>
<script>
    export default {
        props: ['users'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
            }
        },

        methods : {
            view(){
                this.$emit('status',true);
            }
        }
    }
</script>