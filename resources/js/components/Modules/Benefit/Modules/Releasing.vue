<template>
    <div>
        <div class="card-body border-bottom">
            <div class="page-title-left mt-n2 ms-n3 mb-n3">
                <ol class="breadcrumb m-0 font-size-15">
                    <li class="breadcrumb-item fw-bold">{{ group.academic_year }}</li>
                    <li class="breadcrumb-item active"><span>{{group.semester.name }}</span></li>
                    <li class="breadcrumb-item active"><span>{{month.month }}</span></li>
                    <li class="breadcrumb-item active"><span class="fw-bold text-primary">Release no. {{ month.releases.length + 1}}</span></li>
                </ol>
            </div>
             <div class="float-end mt-n2">
                <button @click="back" type="button" class="mt-n4 btn btn-sm btn-label btn-secondary"><i class="bx bxs-chevrons-left label-icon"></i> Back </button>
            </div>
        </div>
        <div class="card-body" :style="{ height: (height-123) + 'px' }">
            <div class="table-responsive">
                <table class="table table-centered table-bordered table-nowrap">
                    <thead class="thead-light align-middle">
                        <tr class="font-size-11">
                            <th style="width: 25%">Name</th>
                            <th style="width: 15%" class="font-size-10 text-center">Stipend</th>
                            <th style="width: 15%" class="font-size-10 text-center">Book Allowance</th>
                            <th style="width: 15%" class="font-size-10 text-center">Tuition</th>
                            <th style="width: 15%" class="font-size-10 text-center">Others</th>
                            <th style="width: 15%" class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <tr v-if="lists.length == 0">
                            <td colspan="6" class="text-center text-muted">No Pending Scholars</td>
                        </tr>
                        <tr v-else v-for="user in lists.lists" v-bind:key="user.id">
                            <td style="cursor: pointer;">
                                <h5 class="font-size-11  mb-0">{{user.scholar.lastname}}, {{user.scholar.firstname}} {{user.scholar.middlename}}</h5>
                            </td>
                            <td class="text-center font-size-11" v-for="(benefit,index) in user.benefits" v-bind:key="index">
                                {{ formatMoney(benefit.amount) }}
                            </td>
                            <td class="text-center text-success fw-bold font-size-11">
                                ₱ {{ formatMoney(user.total) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body border-top">
            <div class="float-end">
                <button @click="release" :disabled="(lists.length == 0) ? true : false" type="button" class="btn w-md ml-1 btn-sm btn-primary mb-3 mt-n1">Create</button>
            </div>
        </div>
        <Release ref="release"/>
    </div>
</template>
<script>
import Release from "../Modals/Release.vue";
export default {
    components : { Release },
    props: ['height'],
    data(){
        return {
            currentUrl: window.location.origin,
            month: {releases: []},
            group: {semester: {}},
            scholars: '',
            lists: []
        }
    },

    methods : {
        set(data){
            this.group = data.group;
            this.month = data.month.name;
            this.scholars = data.month.pending;
            this.fetch();
        },

        fetch() {
            if(this.scholars.length > 0){
                axios.get(this.currentUrl + '/request/benefit/generate/'+JSON.stringify(this.scholars))
                .then(response => {
                    this.lists = response.data;
                })
                .catch(err => console.log(err));
            }
        },

        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

        release(){
            this.$refs.release.set(this.month,this.lists);
            this.$bvModal.show("newrelease");
        },

        back(){
            this.$emit('status', true);
        }
    }   
}
</script>