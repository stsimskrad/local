<template>
    <div>
        <div class="card-body border-bottom">
            <div class="page-title-left">
                <h6 class="fw-bold mb-n1">Statuses</h6>
            </div>
        </div>
        <div class="card-body" style="height: 388px;">
            <ul class="list-group list-group-flush">
                <li v-if="index < 5" class="list-group-item" v-for="(status,index) in statuses" v-bind:key="index">
                    <div class="py-1">
                        <h5 class="font-size-12">
                            {{ status.name }} <span class="float-end"> {{percentage(status.status_count)}} ({{status.status_count }})</span>
                        </h5>
                        <div class="progress animated-progess progress-sm">
                            <div class="progress-bar" :class="'bg-'+status.color" role="progressbar" :style="'width: '+percentage(status.status_count)" :aria-valuenow="status.status_count"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['statuses','total'],
        data() {
            return {
                currentUrl: window.location.origin
            }
        }, 
        methods : {
            percentage(data){
                return Math.floor((data/this.total)*100)+'%';
            }
        }
    }

</script>
