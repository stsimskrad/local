<template>
<div>
    <PageHeader :title="title" :items="items" />
    <Index/>
</div>
</template>
<script>
    import Index from '../Modules/Download/Index.vue';
    import Layout from '../Layouts/main.vue';
    import PageHeader from '../Layouts/Header.vue';

    export default {
        components: { Layout, PageHeader, Index },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Downloads",
                items: [
                    {text: "Download", href: "/",},
                    {text: "Lists",active: true,},
                ],
            };
        },
        
    }
</script>