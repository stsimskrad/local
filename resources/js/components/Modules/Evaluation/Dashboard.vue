<template>
    <div class="row g-3" v-if="failures.length > 0">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body" :style="{ height: (hayt-90) + 'px' }"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body" :style="{ height: (hayt-90) + 'px' }"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body mb-n4">
                    <div class="d-flex flex-wrap">
                        <h5 class="card-title text-muted mb-3 me-2">Scholars</h5>
                    </div>
                </div>
                <div class="card-body mb-n2 border-top">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <p class="text-warning fw-bold mb-0 font-size-11">{{ failures[0].name }}</p>
                                <h5>{{ failures[0].count }} <span class="fw-bold font-size-13">Scholar/'s</span></h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end mt-4 mt-sm-0">
                                <p class="text-danger fw-bold mb-0 font-size-11">{{ failures[1].name }}</p>
                                <h5>{{ failures[1].count }} <span class="fw-bold font-size-13">Scholar/'s</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top" :style="{ height: (hayt-218) + 'px' }">
                    <h6 class="fw-bold mb-3 me-2">Most Failed Subjects</h6>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <tbody>
                                <tr v-for="(subject,index) in failures[2].data.data" v-bind:key="index" style="cursor: pointer;">
                                    <td>
                                        <h5 class="font-size-13 mb-0">{{subject.code}}</h5>
                                        <p class="text-muted mb-0">{{subject.subject}}</p>
                                    </td>
                                    <td class="text-end">
                                        <h5 class="mb-0">{{subject.total}}</h5>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['height'],
        data() {
            return {
                currentUrl: window.location.origin,
                failures: []
            }
        },

        computed: {
            hayt: function () {
                if (this.advanced) {
                    return this.height - 72;
                } else {
                    return this.height;
                }
            }
        },

        created() {
            this.fetchFails();
        },

        methods: {
            fetchFails() {
                axios.get(this.currentUrl + '/request/evaluation/enrollment/reports')
                    .then(response => {
                        this.failures = response.data;
                    })
                    .catch(err => console.log(err));
            }
        }
    }

</script>
