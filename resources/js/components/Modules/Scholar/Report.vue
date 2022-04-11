<template>
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div :style="{ height: (height-70) + 'px' }" data-simplebar>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" v-for="category in categories" v-bind:key="category.id">
                                <div class="">
                                    <h5 class="font-size-12">{{ category.name}} <span class="float-end text-primary">{{ category.count }}</span></h5>
                                    <div class="progress progress-xl">
                                        <div class="progress-bar bg-success" role="progressbar" :style="'width:'+parseFloat((category.graduate/category.total) * 100).toFixed(2)+'%;'" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{category.graduate}}</div>
                                        <div class="progress-bar bg-info" role="progressbar" :style="'width:'+parseFloat((category.good/category.total) * 100).toFixed(2)+'%;'" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">{{category.good}}</div>
                                        <div class="progress-bar bg-warning" role="progressbar" :style="'width:'+parseFloat((category.warning/category.total) * 100).toFixed(2)+'%;'" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{category.warning}}</div>
                                    </div>
                                    <!-- <div class="progress animated-progess progress-sm">
                                        <div class="progress-bar" role="progressbar" :style="'width:'+parseFloat((category.count/category.total) * 100).toFixed(2)+'%;'" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> -->
                                </div>
                            </li>    
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row g-3">
                <div class="col-md-4" v-for="(stat,index) in stats" v-bind:key="index">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">{{stat.name}}</p>
                                    <h4 class="mb-0">{{stat.counts}}</h4>
                                </div>
                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title"><i :class="'bx '+stat.icon+' font-size-24'"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-xl-12 mb-4">
                            <button style="margin-top: 5px; cursor: default;" class="btn btn-sm btn-light pull-right" type="button">Print Reports</button>
                            <hr class="float-end" style="width: 90%;">
                        </div>

                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="currency" id="buycurrencyoption1" class="card-radio-input">

                                    <div class="card-radio">
                                        <div>
                                            <i class='bx bxs-award font-size-24 text-warning align-middle me-2'></i>
                                            <span>Graduates <span class="font-size-10 text-muted">(w/ honor)</span></span>
                                            <i class='bx bxs-printer float-end font-size-24 text-light align-middle me-2'></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="currency" id="buycurrencyoption2" class="card-radio-input">

                                    <div class="card-radio">
                                        <div>
                                            <i class='bx bxs-graduation font-size-24 text-warning align-middle me-2'></i>
                                            <span>List of Graduates</span>
                                            <i class='bx bxs-printer float-end font-size-24 text-light align-middle me-2'></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="currency" id="buycurrencyoption3" class="card-radio-input">

                                    <div class="card-radio">
                                        <div>
                                            <i class='bx bxs-group font-size-24 text-warning align-middle me-2'></i>
                                            <span>List of Scholars</span>
                                                <i class='bx bxs-printer float-end font-size-24 text-light align-middle me-2'></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-xl-12 mt-1 mb-4">
                            <button style="margin-top: 5px; cursor: default;" class="btn btn-sm btn-light pull-right" type="button">Count per Status</button>
                            <hr class="float-end" style="width: 88%;">
                        </div>

                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="font-size-11">
                                        <tr class="text-center">
                                            <th colspan="4" class="text-success">Ongoing</th>
                                            <th colspan="4"></th>
                                        </tr>
                                        <tr class="text-center font-size-10">
                                            <th scope="col" v-for="status in statuses" v-bind:key="status.id">{{status.name}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td v-for="status in statuses" v-bind:key="status.id">{{status.count}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>


<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                windowHeight: window.innerHeight,
                windowWidth: window.innerWidth,
                errors: [],
                pagination: {},
                keyword: '',
                categories: [],
                statuses: [],
                stats: []
            }
        },

        computed: {
            height: function () {
                return this.windowHeight - 170;
            },
            width: function () {
                return this.windowWidth;
            },
            counts: function () {
                return Math.floor((this.height - 125) / 60);
            }
        },

        created() {
            this.category();
            this.status();
            this.totals();
        },

        methods: {
            category() {
                axios.get(this.currentUrl + '/request/scholar/reports/category')
                    .then(response => {
                        this.categories = response.data;
                        return this.categories.sort((a, b) => b.count - a.count);
                    })
                    .catch(err => console.log(err));
            },

            status() {
                axios.get(this.currentUrl + '/request/scholar/reports/status')
                    .then(response => {
                        this.statuses = response.data;
                    })
                    .catch(err => console.log(err));
            },

            totals() {
                axios.get(this.currentUrl + '/request/scholar/reports/totals')
                    .then(response => {
                        this.stats = response.data;
                    })
                    .catch(err => console.log(err));
            }
        },
    }

</script>
