<template>
<div>
    <PageHeader :title="title" :items="items" />
    <Index ref="enrollment" :height="height" :dropdowns="dropdowns"/> 
</div>
</template>
<script>
    import Index from '../Modules/Enrollment/Index.vue';
    import PageHeader from '../Layouts/Header.vue';

    export default {
        components: { PageHeader, Index },
        props: ['dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Enrollments",
                items: [
                    {text: "Enrollment", href: "/",},
                    {text: "Lists", href: "/",}
                ],
            };
        },
        
    }
</script>