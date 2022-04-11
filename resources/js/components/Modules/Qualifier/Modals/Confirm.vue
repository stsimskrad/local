<template>
    <b-modal id="confirm" hide-footer title="Confirm" no-close-on-backdrop centered>
        <center><span class="text-muted mb-4">Are you sure you want to sync the <span class="font-weight-bold text-danger"> {{ users.length }}</span> qualifiers?</span></center>
        <center><button type="button" @click="sync" class="mt-4 mb-4 btn btn-warning w-md waves-effect waves-light">SYNC</button></center>
        <loading :active.sync="isLoading" :can-cancel="true" loader="dots" background-color="black" :is-full-page="fullPage"></loading>
    </b-modal>
</template>
<script>
    import Loading from 'vue-loading-overlay';
    export default {
        props: ['users','type'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                qualifiers: [],
                isLoading: false,
                fullPage: true,
            }
        },

        methods : {
            sync(){
                let url;
                this.isLoading = true;
                this.qualifiers = this.users;

                (this.type == 'scholar') ? url = this.currentUrl + '/excel/scholar/store' : url = this.currentUrl + '/excel/qualifier/store';
                axios.post(url, {
                    users: this.qualifiers,
                })
                .then(response => {
                    this.$emit('status', response.data);
                    this.isLoading = false;
                    this.$bvModal.hide("confirm");
                    Vue.$toast.success('<strong>Successfully Synced</strong>', {
                        position: 'bottom-right'
                    });
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
            }
        }, components : { Loading }
    }
</script>