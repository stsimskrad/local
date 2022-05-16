<template>
    <section class="section pt-4 bg-white" id="about">
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="row g-3">
                        <div class="col-lg-4" v-for="(total,index) in totals" v-bind:key="index">
                            <div class="card border mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="me-3">
                                            <p class="text-muted mb-2">{{ total.name }}</p>
                                            <h5 class="mb-0">{{ total.counts }}</h5>
                                        </div>
                                        <div class="avatar-sm ms-auto">
                                            <div class="avatar-title bg-light rounded-circle font-size-20"
                                                :class="'text-'+total.color">
                                                <i class="bx" :class="total.icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body">
                            <Lists />
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</template>

<script>
    import Lists from "../../Modules/Home/Coordinator/Lists.vue";

    export default {
        components: { Lists },
        data() {
            return {
                currentUrl: window.location.origin,
                totals: []
            };
        },

        created(){
            this.fetchTotals();
        },

        methods : {
            fetchTotals() {
                axios.get(this.currentUrl + '/public/totals')
                .then(response => {
                    this.totals = response.data;
                })
                .catch(err => console.log(err));
            },
        }
    };
</script>
