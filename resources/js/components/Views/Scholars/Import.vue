<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" :style="{ height: height + 'px' }">
                    <Index/>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import Index from '../../Modules/Scholar/Import.vue'
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        components: { PageHeader, Index },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Import Scholars",
                items: [
                    {text: "Scholar", href: "/",},
                    {text: "Import",active: true,},
                ],
            };
        },
    }
</script>