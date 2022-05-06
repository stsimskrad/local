<template>
<div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" :style="{ height: height + 'px' }">
                    <Index @status="message" :programs="programs" :regions="regions" :dropdowns="dropdowns" />
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import Index from '../../Modules/Scholar/Index.vue'
    import PageHeader from '../../Layouts/Header.vue';

    export default {
        props: ['dropdowns','regions', 'programs', 'benefits'],
        components: { PageHeader, Index },
        data() {
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.height, 
                title: "Scholars",
                program: 'all',
                ss: 'all',
            };
        },
        computed : {
            items : function(){
                return [
                    {text: "Home", href: "/",},
                    {text: "Scholars", href: "/",},
                    {text: this.program, active: true,},
                    {text: this.ss, active: true,},
                ];
            }
        },
        methods : {
            message(...args){
                const [x,y] = args;
                if(x == 'program'){
                    this.program = y;
                }else{
                    this.ss = y;
                }
            }
        }
    }
</script>