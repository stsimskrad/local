<template>
    <section class="section pt-4 bg-white" id="about">
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="row g-3">
                        <div class="col-lg-4">
                            <div class="card border mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="me-3">
                                            <p class="text-muted mb-2">Total Scholars</p>
                                            <h5 class="mb-0">981</h5>
                                        </div>
                                        <div class="avatar-sm ms-auto">
                                            <div
                                                class="avatar-title bg-light rounded-circle font-size-20 text-success">
                                                <i class="bx bx-group"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="me-3">
                                            <p class="text-muted mb-2">Total Graduates</p>
                                            <h5 class="mb-0">651</h5>
                                        </div>
                                        <div class="avatar-sm ms-auto">
                                            <div
                                                class="avatar-title bg-light rounded-circle font-size-20 text-info">
                                                <i class="bx bxs-graduation"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="me-3">
                                            <p class="text-muted mb-2">Ongoing Scholars</p>
                                            <h5 class="mb-0">168</h5>
                                        </div>
                                        <div class="avatar-sm ms-auto">
                                            <div
                                                class="avatar-title bg-light rounded-circle font-size-20 text-primary">
                                                <i class="bx bx-user-circle"></i></div>
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
            };
        },
    };
</script>
