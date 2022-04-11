<template>
<div :style="{ 'max-height': (height-50) + 'px' }" style="overflow: auto;">
    <div class="row g-0" v-for="(semester,index) in info.prospectus" v-bind:key="index">
        <table class="table  table-sm table-bordered mb-0 font-size-10"> 
            <thead>
                <tr class="text-center border-0">
                    <th colspan="6" class="border-0"> {{semester.year_level}} </th>
                </tr>
            </thead>
        </table>
        <div class="col-md-6" v-for="(s,index2) in semester.semesters" v-bind:key="index2" v-if="index2 !== 2">
            <table class="table  table-sm table-bordered mb-4 font-size-10"> 
                <thead>
                    <tr class="text-center border-0">
                        <th colspan="3" class="border-0"> {{ s.semester }} </th>
                    </tr>
                    <tr class="text-center">
                        <th>Subject</th>
                        <th>Unit</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="(c,index3) in s.courses" v-bind:key="index3">
                        <td>
                            {{ c.code}}
                        </td>
                        <td>
                            {{ c.unit}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin, 
            height: this.$parent.$parent.$parent.$parent.$parent.height,
            counts: this.$parent.$parent.$parent.$parent.$parent.counts,
            id: '',
            prospectus: {},
            info : {}
        }
    },

    created(){
        this.id = this.$route.params.id;
        this.fetch();
    },

    methods : {
       fetch(){
            axios.get(this.currentUrl+'/request/enrollment/prospectus/'+this.id)
            .then(response => {
                this.prospectus = response.data.data;
                this.info = JSON.parse(this.prospectus.information);
            })
            .catch(err => console.log(err));
        }
    }
}
</script>