<template>
    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <div class="text-muted">
                                <h5 class="mb-0">{{agency.name}}</h5>
                                <p class="mb-0">{{agency.region.name}}, {{agency.region.region}}</p>
                                <p class="mb-0">{{agency.acronym}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top mb-n3">
                    <i @click="fetchLocations()" class='text-muted float-end bx bx-sync h3'
                        style="cursor: pointer;"></i>
                    <p class="text-muted fw-bold">{{agency.region.name}}, {{agency.region.region}}</p>
                </div>
                <div class="card-body border-top">
                    <div class="text-center text-muted">
                        <div class="row">
                            <div class="col-4" v-for="(value, name, index) in region" v-bind:key="index">
                                <div class="mt-0 mb-n3">
                                    <p class="mb-0 text-truncate"><i class="bx bxs-map text-primary me-1"></i>{{name}}
                                    </p>
                                    <h5>{{ value }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top mb-n3">
                    <i @click="fetchLocations()" class='text-muted float-end bx bx-sync h3'
                        style="cursor: pointer;"></i>
                    <p class="text-muted fw-bold">Philippine Addresses</p>
                </div>
                <div class="card-body border-top">
                    <div v-if="loading1 == false" class="mt-n3">
                        <div role="alert" aria-live="polite" aria-atomic="true"
                            class="mt-2 alert alert-dismissible alert-warning">
                            <i class="mdi mdi-alert-circle-outline me-2"></i>Municipality and Barangay district can be
                            updated later on.
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-3" v-for="(value, name, index) in addresses" v-bind:key="index">
                                <div>
                                    <div class="font-size-24 text-primary mb-2"><i class="bx bxs-cloud-download"></i>
                                    </div>
                                    <p class="text-muted mb-2">{{name}}</p>
                                    <p>{{value.downloaded}} <span class="text-muted">of</span> <span
                                            :class="[(value.downloaded != value.count ? 'text-danger' : '')]">{{value.count}}</span>
                                    </p>
                                    <div class="mt-3"><button @click="download(name,index)"
                                            class="btn btn-primary btn-sm w-md"
                                            :disabled="(value.downloaded == value.count) ? true : false">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="loading1 == true">
                            <i class='bx bx-loader-circle bx-spin bx-rotate-90 h1'></i>
                        </div>
                    </div>
                    <div v-if="loading1 == false" class="mt-4">
                        <!-- <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-dismissible alert-warning">
                            <i class="mdi mdi-alert-circle-outline me-2"></i>Municipality and Barangay district can be updated later on.
                        </div> -->
                        <p class="text-muted font-size-11">Current data is as of June 30, 2021. Data is based from <a
                                class="fw-bold" href="https://psa.gov.ph/classification/psgc/"
                                target="_blank">Philippine Standard Geographic Code (PSGC).</a></p>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="row g-3">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <i @click="fetchLists()" class='text-muted float-end bx bx-sync h3'
                                style="cursor: pointer;"></i>
                            <p class="text-muted fw-bold">Schools</p>
                        </div>
                        <div class="card-body mt-n3 border-top">
                            <div class="text-center" v-if="loading3 == true" style="height: 115px">
                                <i class='bx bx-loader-circle bx-spin bx-rotate-90 h1 mt-4'></i>
                            </div>
                            <div v-else class="row" style="margin-top: -7px;">
                                <div class="col-sm-6">
                                    <div>
                                        <h5>Overall Schools</h5>
                                        <p class="text-muted mb-0"><span class="fw-bold">{{ school.overall.all}}</span> Total schools</p>
                                        <p class="text-muted mb-0"><span class="fw-bold">{{ school.overall.campuses}}</span> Total campuses</p>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-start mt-4 mt-sm-0">
                                        <h5>{{agency.region.region}} Schools</h5>
                                        <p class="text-muted mb-0">Schools : <span class="fw-bold">{{ school.regional.downloaded_schools}} of {{ school.regional.all}}</span> downloaded</p>
                                        <p class="text-muted mb-0">Other Schools : <span class="fw-bold">{{ school.regional.other_schools}}</span> downloaded</p>
                                       
                                    </div>
                                </div>
                                <div class="col-sm-12 border-top mb-2 mt-2"></div>
                                <div class="col-sm-6 mb-n2">
                                    <div>
                                       <p class="text-muted mb-0"><span class="fw-bold">{{ school.regional.all}}</span> Schools within {{agency.region.region}}</p>
                                        <p class="text-muted mb-0"><span class="fw-bold">{{ school.regional.campuses}}</span> Campuses within {{agency.region.region}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-n2">
                                    <div class="text-sm-start mt-4 mt-sm-0">
                                        <p class="text-muted mb-0">Campuses : <span class="fw-bold">{{ school.regional.downloaded_campuses}} of {{ school.regional.campuses}}</span> downloaded</p>
                                        <p class="text-muted mb-2">Other Campuses : <span class="fw-bold">{{ school.regional.other_campuses}}</span> downloaded</p>
                                        <!-- <button type="button" @click="downloadSchools" class="btn btn-primary btn-sm w-md me-1">Download</button>
                                        <button class="btn btn-light btn-sm w-md">Request</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-sm-12">
                    <div class="card mt-n2">
                        <div class="card-body">
                            <i @click="fetchLists()" class='text-muted float-end bx bx-sync h3'
                                style="cursor: pointer;"></i>
                            <p class="text-muted fw-bold">Lists</p>
                        </div>
                        <div class="card-body mt-n3 border-top">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-hover mb-0 mt-n1">
                                    <tbody>
                                        <tr class="font-size-11">
                                            <th>Name</th>
                                            <th class="text-center">Count</th>
                                            <th class="text-center">Pending</th>
                                            <th></th>
                                        </tr>
                                        <tr v-for="(value, name, index) in lists" v-bind:key="index">
                                            <td>
                                                <a href="javascript: void(0);" class="text-dark fw-medium">
                                                    <i
                                                        class="bx bx-cloud-download  font-size-16 align-middle text-primary me-2"></i>{{ name }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{value.downloaded}} <span
                                                    class="text-muted">of</span> <span
                                                    :class="[(value.downloaded != value.count ? 'text-danger' : '')]">{{value.count}}</span>
                                            </td>
                                            <td class="text-center">0</td>
                                            <td class="text-end">
                                                <button class="btn btn-success btn-sm w-md">Request</button>
                                                <button @click="downloadLists(name,index)"
                                                    class="btn btn-primary btn-sm"
                                                    :disabled="(value.downloaded == value.count) ? true : false"><i
                                                        class='bx bx-download'></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center" v-if="loading2 == true">
                                <i class='bx bx-loader-circle bx-spin bx-rotate-90 h1'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <loading :active.sync="isLoading" :can-cancel="false" loader="dots" background-color="black"
            :is-full-page="fullPage"></loading>
    </div>
</template>
<script>
    import Loading from 'vue-loading-overlay';
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                counts: this.$parent.$parent.$parent.$parent.counts,
                pagination: {},
                addresses: [],
                lists: [],
                school: {},
                loading1: false,
                loading2: false,
                loading3: false,
                isLoading: false,
                fullPage: true,
                agency: {
                    region: {}
                },
                region: []
            }
        },

        created() {
            this.fetch();
            this.fetchSchools();
            this.fetchLocations();
            this.fetchLists();
        },

        methods: {
            fetch() {
                axios.get(this.currentUrl + '/request/download/info')
                    .then(response => {
                        this.agency = response.data.agency;
                        this.region = response.data.region;
                    })
                    .catch(err => console.log(err));
            },

            fetchSchools(){
                axios.get(this.currentUrl + '/sync/schools/check/all')
                    .then(response => {
                        this.school = response.data;
                    })
                    .catch(err => console.log(err));
            },

            downloadSchools(category, index) {
                this.loading3 = true;
                axios.get(this.currentUrl + '/sync/schools/download/local')
                    .then(response => {
                        this.loading3 = false;
                        this.fetchSchools();
                        Vue.$toast.success('<strong>Schools was downloaded!</strong>', {
                            position: 'bottom-right'
                        });
                    })
                    .catch(err => console.log(err));
            },

            fetchLocations() {
                this.addresses = [];
                this.loading1 = true;
                axios.get(this.currentUrl + '/sync/addresses/check/all')
                    .then(response => {
                        this.addresses = response.data;
                        this.loading1 = false;
                    })
                    .catch(err => console.log(err));
            },

            download(category, index) {
                this.isLoading = true;
                axios.get(this.currentUrl + '/sync/addresses/download/' + category)
                    .then(response => {
                        this.isLoading = false;
                        this.addresses[category].downloaded = response.data;
                        Vue.$toast.success('<strong>' + category + ' lists was downloaded!</strong>', {
                            position: 'bottom-right'
                        });
                    })
                    .catch(err => console.log(err));
            },

            fetchLists() {
                this.lists = [];
                this.loading2 = true;
                axios.get(this.currentUrl + '/sync/lists/check/all')
                    .then(response => {
                        this.lists = response.data;
                        this.loading2 = false;
                    })
                    .catch(err => console.log(err));
            },

            downloadLists(category, index) {
                this.isLoading = true;
                axios.get(this.currentUrl + '/sync/lists/download/' + category)
                    .then(response => {
                        this.isLoading = false;
                        this.lists[category].downloaded = response.data;
                        Vue.$toast.success('<strong>' + category + ' lists was downloaded!</strong>', {
                            position: 'bottom-right'
                        });
                    })
                    .catch(err => console.log(err));
            },
        },
        components: {
            Loading
        }
    }

</script>
