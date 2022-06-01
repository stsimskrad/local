<template>
    <div>
        <b-tabs content-class="p-3 text-muted">
            <b-tab active class="border-0">
                <template v-slot:title>
                    <span class="d-inline-block d-sm-none">
                        <i class="fas fa-home"></i>
                    </span>
                    <span class="d-none d-sm-inline-block">Home</span>
                </template>
                {{ text }}
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <span class="d-inline-block d-sm-none">
                        <i class="far fa-user"></i>
                    </span>
                    <span class="d-none d-sm-inline-block">Allotments</span>
                </template>
                <Allotment />
            </b-tab>
            <b-tab>
                <template v-slot:title>
                    <span class="d-inline-block d-sm-none">
                        <i class="far fa-envelope"></i>
                    </span>
                    <span class="d-none d-sm-inline-block">Disbursements</span>
                </template>
                <Disbursement :expenses="expenses"/>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
import Allotment from './Allotment/Index.vue';
import Disbursement from './Disbursement/Index.vue';
export default {
    props : ['expenses'],
    components : { Allotment, Disbursement },
    data() {
        return {
            title: "Tabs & Accordions",
            items: [{
                    text: "UI Elements",
                    href: "/"
                },
                {
                    text: "Tabs & Accordions",
                    active: true
                }
            ],
            text: `
        Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.
    `,
            content: `Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus.`
        };
    }
};
</script>
