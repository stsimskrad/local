<template>
    <div>
       <b-tabs content-class="text-muted mt-3" fill>
            <b-tab active class="border-0">
                <template v-slot:title>
                    <i class="bx bxs-notepad "></i>
                    <span class="d-none d-sm-inline-block">Information</span>
                </template>
                <Info :id="id" :height="height" :counts="counts"/>
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <i class="bx bx-history"></i>
                    <span class="d-none d-sm-inline-block">History</span>
                </template>
                <History :id="id" :height="height" :counts="counts"/>
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <i class="bx bx-briefcase"></i>
                    <span class="d-none d-sm-inline-block">Affliation</span>
                </template>
                <Affliation :id="id" :height="height" :counts="counts"/>
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <i class="bx bxs-award"></i>
                    <span class="d-none d-sm-inline-block">Awards</span>
                </template>
                <Award :id="id" :height="height" :counts="counts"/>
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <i class="bx bx-notepad "></i>
                    <span class="d-none d-sm-inline-block">R&D</span>
                </template>
                <Research :id="id" :height="height" :counts="counts"/>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
import Affliation from './Lists/Affliation.vue';
import Award from './Lists/Award.vue';
import History from './Lists/History.vue';
import Research from './Lists/Research.vue';
import Info from './Lists/Info.vue';

export default {
     data(){
        return {
            currentUrl: window.location.origin, 
            height: this.$parent.$parent.$parent.$parent.$parent.height,
            counts: this.$parent.$parent.$parent.$parent.$parent.counts,
            id: '',
            type: ''
        }
    },

    created(){
        this.id = this.$route.params.id;
    },
    components : {Affliation, Award, History, Research, Info}
}
</script>