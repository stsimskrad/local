<template>
    <b-modal id="program" size="lg" title="Programs" hide-footer centered>
         <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="(list,index) in main" v-bind:key="index">
                <div class="py-1">
                    <h5 class="font-size-12">
                        {{ list.name }} 
                        <span class="float-end">{{list.scholar_count}} <span class="text-muted">({{ per(list.scholar_count) }}%)</span></span>
                       
                    </h5>
                    <div class="progress animated-progess progress-sm">
                       <div class="progress-bar" role="progressbar" :style="'width: '+per(list.scholar_count)+'%'"
                                                aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </li>
        </ul>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                main : [],
                total: ''
            }
        },

        methods: {
            set(data,total){
                this.main = data;
                this.total = total;
            },

            per(data){
                return parseFloat((data / this.total) * 100).toFixed(2);
            },

        }
    }

</script>

</template>