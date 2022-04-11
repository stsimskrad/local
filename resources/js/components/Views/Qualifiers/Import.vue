<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" :style="{ height: height + 'px' }">
                    <Import/>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import Import from '../../Modules/Qualifier/Import.vue';
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        components: { PageHeader, Import },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Import Qualifiers",
                items: [
                    {text: "Qualifier", href: "/",},
                    {text: "Import", active: true,},
                ],
            };
        },
        
    }
</script>