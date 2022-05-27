<template>
    <b-modal id="stat" size="lg" title="Statuses" hide-footer centered>
        <div>
            <ul class="list-group list-group-flush" data-simplebar style="height: 380px;">
                <li class="list-group-item" v-for="(status,index) in statuses" v-bind:key="index">
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
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                statuses : [],
                total: ''
            }
        },

        methods: {
            set(data,total){
                this.statuses = data;
                this.total = total;
            },
            percentage(data){
                let a = (data/this.total)*100;
                return a.toFixed(1)+'%';
            }

        }
    }

</script>

</template>