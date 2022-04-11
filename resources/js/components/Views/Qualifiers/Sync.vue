<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" :style="{ height: height + 'px' }">
                    <Sync/>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import Sync from '../../Modules/Qualifier/Sync.vue';
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        components: { PageHeader, Sync },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Sync Qualifiers",
                items: [
                    {text: "Qualifier", href: "/",},
                    {text: "Sync",active: true,},
                ],
            };
        },
        
    }
</script>