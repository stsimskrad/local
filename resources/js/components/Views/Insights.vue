<template>
<div>
    <PageHeader :title="title" :items="items" />
    <Index :height="height" :dropdowns="dropdowns"/> 
</div>
</template>
<script>
    import Index from '../Modules/Insights/Index.vue';
    import PageHeader from '../Layouts/Header.vue';

    export default {
        components: { PageHeader, Index },
        props: ['dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Insights",
                items: [
                    {text: "Lists", href: "/",},
                    {text: "insight", active: true}
                ],
            };
        },
        
    }
</script>