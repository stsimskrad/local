<template>
    <div>
        <div class="text-center mb-2 text-muted">
            <a to="/" class="d-block auth-logo">
                <img src="/images/logo-dost.png" alt="" height="20" class="auth-logo-dark mx-auto" />
            </a>
            <p class="font-size-11 mt-3">Department of Science & Technology <br> Scholarship Information Management System</p>
        </div>
        <div class="mb-4" style="width: 400px;">
            <div class="">
                <div class="table-responsive">
                    <table class="table table-nowrap table-centered table-hover mb-0 align-middle">
                        <tbody>
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft bg-primary text-primary font-size-24">
                                            <i class="bx bx-map"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-13 mb-0"><a  class="text-dark">Philippine Standard Geographic Code</a></h5>
                                    <small>Region : {{regions.count }}</small>
                                </td>
                                <td>
                                    <div class="text-center"><a @click="downloadRegion()" class="text-dark"><i class="bx bx-download h3 m-0"></i></a></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft bg-primary text-primary font-size-24">
                                            <i class="bx bx-buildings"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-14 mb-0"><a href="javascript: void(0);" class="text-dark">DOST Agencies</a></h5>
                                    <small>Total : {{agencies.count }}</small>
                                </td>
                                <td>
                                    <div class="text-center"><a @click="downloadLists()" class="text-dark"><i class="bx bx-download h3 m-0"></i></a></div>
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>
                <center>
                    <button @click="proceed" :disabled="(agencies.data.length == 0)" type="button" class="mt-4 mb-4 btn w-lg btn-primary">Proceed</button>
                </center>
            </div>
        </div>
         <loading :active.sync="isLoading" :can-cancel="false" loader="dots" background-color="black"
            :is-full-page="fullPage"></loading>
    </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
export default {
    components : { Loading },
    props: ['id'],
    data(){
        return {
            currentUrl: window.location.origin,
            addresses : [],
            regions: [],
            agencies: [],
            isLoading: false,
            fullPage: true,
            lists : [],
            agency: '',
            region: ''
        }
    },

    created(){
        this.fetch();
        this.fetchLocations();
        this.fetchLists();
    },

    methods : {
        fetch() {
            axios.get(this.currentUrl + '/request/download/info')
            .then(response => {
                this.agency = response.data.agency;
                this.region = response.data.region;
            })
            .catch(err => console.log(err));
        },

        fetchLocations() {
            this.isLoading = true;
            axios.get(this.currentUrl + '/sync/addresses/check/all')
            .then(response => {
                this.isLoading = false;
                this.addresses = response.data;
                this.regions = response.data.Regions;
            })
            .catch(err => console.log(err));
        },

         downloadRegion() {
            this.isLoading = true;
            let category = 'Regions';
            axios.get(this.currentUrl + '/sync/addresses/download/' + category)
            .then(response => {
                this.isLoading = false;
                Vue.$toast.success('<strong>' + category + ' lists was downloaded!</strong>', {
                    position: 'bottom-right'
                });
            })
            .catch(err => console.log(err));
        },

        fetchLists() {
            axios.get(this.currentUrl + '/sync/lists/check/all')
            .then(response => {
                this.lists = response.data;
                this.agencies = response.data.Agencies;
            })
            .catch(err => console.log(err));
        },

         downloadLists() {
            let category = 'Agencies';
            this.isLoading = true;
            axios.get(this.currentUrl + '/sync/lists/download/' + category)
            .then(response => {
                this.isLoading = false;
                this.fetchLists();
                if(response.data == 0){
                    Vue.$toast.error('<strong>Please download PSGC Regions first.</strong>', {
                        position: 'bottom-right'
                    });
                }else{
                    Vue.$toast.success('<strong>' + category + ' lists was downloaded!</strong>', {
                        position: 'bottom-right'
                    });
                }
            })
            .catch(err => console.log(err));
        },

        proceed(){
            axios.post(this.currentUrl + '/request/user/store', {
                id: this.id,
                is_active: 1,
                editable: true
            })
            .then(response => {
               window.location.reload();
            })
            .catch(err => console.log(err));
        }
    }
}
</script>