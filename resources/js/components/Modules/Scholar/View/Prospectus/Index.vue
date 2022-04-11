<template>
<div>
    <b-tabs v-model="tabIndex">
        <b-tab v-for="(semester,index) in semesters" v-bind:key="index">
            <div class="table-responsive">
                <table class="table table-bordered mb-0"> 
                    <thead>
                        <tr class="text-center text-primary font-weight-bold font-size-12">
                            <th colspan="2">
                                <a class="bx-tada float-start" @click="nxt('back')"><i class='bx bx-chevrons-left' ></i></a>
                                {{semester.year_level.toUpperCase()}}
                                <a class="bx-tada float-end" @click="nxt('next')"><i class='bx bx-chevrons-right'></i></a>
                            </th>
                        </tr>
                    </thead>
                </table>
                <b-tabs v-model="tabIndex2">
                    <b-tab v-for="(s,index2) in semester.semesters" v-bind:key="index2">
                        <table class="table table-bordered mb-0"> 
                            <thead>
                                <tr class="text-center text-danger font-weight-bold font-size-12">
                                    <th colspan="4">
                                        <a class="bx-tada float-start" @click="tabIndex2--"><i class='bx bx-chevrons-left' ></i></a>
                                        <span class="mt-2">{{s.semester.toUpperCase()}} </span>
                                        <!-- <i @click="add(index,index2)" v-if="s.courses.length > 0" class='bx bxs-plus-circle h4 mb-n2 mt-n2 ms-2 text-muted' style="cursor: pointer;"></i> -->
                                        <a class="bx-tada float-end" @click="tabIndex2++"><i class='bx bx-chevrons-right'></i></a>
                                    </th>
                                </tr>
                                <tr class="text-center text-muted font-size-11">
                                    <th style="width: 15%;">Code</th>
                                    <th style="width: 65%;">Subject</th>
                                    <th style="width: 10%;">Unit</th>
                                    <th style="width: 10%;">Grade</th>
                                </tr>
                            </thead>
                        </table>
                        <simplebar :style="{ 'max-height': (height-210) + 'px' }">
                            <table class="table table-bordered mb-0">
                                <tbody class="font-size-12">
                                    <tr v-for="(course, index3) in s.courses" v-bind:key="'a-'+index3">
                                        <td style="width: 15%;" class="text-center">{{ course.code.toUpperCase() }}</td>
                                        <td style="width: 65%;" class="text-center">{{ course.subject }}</td>
                                        <td style="width: 10%;" class="text-center">{{ course.unit }}</td>
                                        <td style="width: 10%;" class="text-center fw-bold text-success">{{ course.grade }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </simplebar>
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr class="text-center font-size-12">
                                    <td style="width: 80%;"></td>
                                    <td style="width: 10%;" class=" fw-bold">{{ totalUnits(s.courses) }}</td>
                                    <td style="width: 10%;" class=" fw-bold text-primary">{{ totalGrade(s.courses) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </b-tab>
                </b-tabs>
            </div>
        </b-tab>
    </b-tabs>
</div>
</template>
<script>
import simplebar from "simplebar-vue";
export default {
    data(){
        return {
            currentUrl: window.location.origin, 
            height: this.$parent.$parent.$parent.$parent.$parent.height,
            counts: this.$parent.$parent.$parent.$parent.$parent.counts,
            tabIndex: 0,
            tabIndex2: 0,
            prospectus: {},
            semesters: [],
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
                this.semesters = JSON.parse(this.prospectus.information);
                this.semesters = this.semesters.prospectus;
            })
            .catch(err => console.log(err));
        },

        totalUnits(lists){
            var sum = 0;
            if(lists != undefined){
                lists.forEach(e => {
                    sum += Number(e.unit);
                });
            }
            return sum
        },

        totalGrade(lists){
            var sum = 0; var tot = 0;
            if(lists != undefined){
                lists.forEach(e => {
                    if(e.is_nonacademic == false && e.grade != undefined){
                        tot++;
                        sum += Number(e.grade);
                    }
                });
            }
            if(sum != 0 || sum != ''){
                return (sum/tot).toFixed(3);
            }else{
                return '-';
            }
        },

        nxt(type){
            (type == 'next') ? this.tabIndex++ : this.tabIndex--;
            this.tabIndex2 = 0;
        },
    }, components : { simplebar }
}
</script>
<style>
.nav-tabs {
    display: none;
}
</style>
