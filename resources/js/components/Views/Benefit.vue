<template>
<div>
    <PageHeader :title="title" :items="items" />
    <Index :height="height" :dropdowns="dropdowns"/> 
</div>
</template>
<script>
    import Index from '../Modules/Benefit/Index.vue';
    import PageHeader from '../Layouts/Header.vue';

    export default {
        components: { PageHeader, Index },
        props: ['dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Financial Benefits",
                items: [
                    {text: "Benefit", href: "/",},
                    {text: "Lists", href: "/",}
                ],
            };
        },
        
    }
</script>