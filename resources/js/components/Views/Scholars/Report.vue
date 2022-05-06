<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <Index :dropdowns="dropdowns" :programs="programs"/>
        </div>
    </div>
</div>
</template>
<script>
    import Index from '../../Modules/Scholar/Report.vue'
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        props: ['dropdowns','programs'],
        components: { PageHeader, Index },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Scholar Reports",
                items: [
                    {text: "Scholar", href: "/",},
                    {text: "Reports",active: true,},
                ],
            };
        },
    }
</script>