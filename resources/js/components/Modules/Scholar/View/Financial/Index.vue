<template>
    <div>
        <b-tabs content-class="text-muted mt-3" fill>
            <b-tab active class="border-0">
                <template v-slot:title>
                    <i class="bx bxs-notepad "></i>
                    <span class="d-none d-sm-inline-block">Lists</span>
                </template>
                <Lists :id="id" :height="height" :counts="counts" :dropdowns="dropdowns"/>
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <i class="bx bx-history"></i>
                    <span class="d-none d-sm-inline-block">Stipend</span>
                </template>
                <Stipend :id="id" :height="height" :counts="counts"/>
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <i class="bx bx-briefcase"></i>
                    <span class="d-none d-sm-inline-block">Breakdown</span>
                </template>
                <Breakdown :id="id" :height="height" :counts="counts"/>
            </b-tab>
        </b-tabs>
    </div>
</template>
<script>
import Lists from './Lists.vue';
import Breakdown from './Breakdown.vue';
import Stipend from './Stipend.vue';''
export default {
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin, 
            height: this.$parent.$parent.$parent.$parent.$parent.height,
            counts: this.$parent.$parent.$parent.$parent.$parent.counts,
            id: '',
        }
    },
    created(){
        this.id = this.$route.params.id;
    },
    components : {Lists, Stipend, Breakdown}
}
</script>