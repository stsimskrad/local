<template>
    <div>
        <div class="row mb-4">
            <div class="col-xl-6">
                <router-link :to="{ name: 'accounting/reports' }">
                    <button  @click="selected = 1" type="button" :class="(selected == 1) ? 'btn-primary text-white' : ''" class="btn w-lg mb-n3 btn-outline-light">Reports</button>
                </router-link>
                <router-link :to="{ name: 'accounting/allotments' }"> 
                    <button @click="selected = 2" type="button" :class="(selected == 2) ? 'btn-primary text-white' : ''" class="btn w-lg mb-n3 btn-outline-light">Allotments</button>
                </router-link>
                <router-link :to="{ name: 'accounting/disbursements' }">
                    <button @click="selected = 3" type="button" :class="(selected == 3) ? 'btn-primary text-white' : ''" class="btn w-lg mb-n3 btn-outline-light">Disbursements</button>
                </router-link>
            </div>
        </div>
        <blockquote class="p-3 border-light border rounded ">
            <router-view :counts="counts"></router-view>
        </blockquote>
    </div>
</template>

<script>
import Allotment from './Allotment/Index.vue';
import Disbursement from './Disbursement/Index.vue';
import FinancialReport from './Report/Index.vue';
export default {
    props : ['expenses'],
    components : { Allotment, Disbursement, FinancialReport },
    data() {
        return {
            counts: this.$parent.$parent.$parent.$parent.counts2,
            selected : 1
        };
    },
};
</script>
