<script>
    import Vertical from "./vertical.vue";
    import Horizontal from "./horizontal.vue"

    export default {
        data(){
            return{
                currentUrl: window.location.origin,
                lists: [],
                user: {profile: {}},
                dropdowns: [],
                regions: [],
                expenses: [],
                benefits: [],
                programs: []
            }
        },
        components: {
            Vertical, Horizontal
        },
         computed: {
            layoutType() {
                return this.$root.layout?.type;
            }
        },
        created(){
            this.fetchLists();
        },
        methods: {
            fetchLists(){
                axios.get(this.currentUrl + '/lists')
                .then(response => {
                    // this.lists = response.data;
                    this.dropdowns = response.data.dropdowns;
                    this.user = response.data.profile;
                    this.regions = response.data.regions;
                    this.expenses = response.data.expenses;
                    this.programs = response.data.programs;
                    this.benefits = response.data.benefits;
                })
                .catch(err => console.log(err));
            },
        }
    };

</script>

<template>
    <div>
        <Vertical :user="user" v-if="layoutType === 'vertical'">
            <router-view :user="user" :benefits="benefits" :programs="programs" :expenses="expenses" :regions="regions" :dropdowns="dropdowns"></router-view>
        </Vertical>

        <Horizontal :user="user" v-if="layoutType === 'horizontal'">
            <router-view :user="user" :benefits="benefits" :programs="programs" :expenses="expenses" :regions="regions" :dropdowns="dropdowns"></router-view>
        </Horizontal>
    </div>
</template>
