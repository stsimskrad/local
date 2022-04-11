<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="page">
        <Index :dropdowns="dropdowns" :regions="regions"/>
    </div>
</div>
</template>
<script>
    import Index from '../../Modules/Scholar/View/Index.vue'
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        components: { PageHeader, Index },
        props: ['dropdowns','regions'],
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Scholar Profile",
            };
        },
        computed : {
            items : function(){
                return [
                    {text: "Home", href: "/",},
                    {text: "Scholars", href: "/",},
                    {text: "Profile", active: true,},
                ];
            }
        }
    }
</script>