<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" :style="{ height: height + 'px' }">
                    <Index :expenses="expenses"/>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import Index from '../../Modules/Accounting/Disbursement/Index.vue'
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        props: ['expenses'],
        components: { PageHeader, Index },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Disbursements",
                items: [
                    {text: "Accounting", href: "/",},
                    {text: "Disbursement", href: "/",},
                    {text: "Lists",active: true,},
                ],
            };
        },
    }
</script>