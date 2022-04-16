<template>
    <div>
        <PageHeader v-if="user.role != 'Scholar'" :title="title" :items="items"/>
        <!-- <Coordinator /> -->
        <Scholar :user="user" :height="height" v-if="user.role == 'Scholar'"/>

    </div>  
</template>
<script>
    // import Coordinator from '../../../components/Modules/Dashboard/Coordinator/Index.vue';
    import Scholar from '../Modules/Home/Scholar.vue'
    import Layout from '../Layouts/main.vue';
    import PageHeader from '../Layouts/Header.vue';

    export default {
        components: { Layout, PageHeader, Scholar },
        props: ['user'],
        data() {
            return {
                height: this.$parent.$parent.$parent.height, 
                title: "Dashboard",
                items: [
                {
                text: "Dashboards",
                href: "/",
                },
                {
                text: "Saas",
                active: true,
                },
      ],
            };
        },
    
    }
</script>