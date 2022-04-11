<template>
<div>
    <PageHeader :title="title" :items="items" />
    <Index :height="height" :dropdowns="dropdowns"/> 
</div>
</template>
<script>
    import Index from '../Modules/Evaluation/Index.vue';
    import PageHeader from '../Layouts/Header.vue';

    export default {
        components: { PageHeader, Index },
        props: ['dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Evaluation / Grading",
                items: [
                    {text: "Lists", href: "/",},
                    {text: "Grading & Evaluation", active: true}
                ],
            };
        },
        
    }
</script>