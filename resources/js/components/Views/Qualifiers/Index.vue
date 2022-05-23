<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" :style="{ height: height + 'px' }">
                    <Index :regions="regions" :programs="programs" :dropdowns="dropdowns" />
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import Index from '../../Modules/Qualifier/Index.vue'
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        props: ['dropdowns','regions','programs'],
        components: { PageHeader, Index },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Qualifiers",
                items: [
                    {text: "Qualifier", href: "/",},
                    {text: "Lists",active: true,},
                ],
            };
        }
    }
</script>