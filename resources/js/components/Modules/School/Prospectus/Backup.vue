<template>
    <b-modal @ok="save($event)" id="prospectus" size="xl" ok-title="Save" title="Prospectus" centered>
        <b-form class="customform mb-2">
            <div class="row">

                <b-tabs v-model="tabIndex">
                    <b-tab v-for="(semester,index) in semesters" v-bind:key="index">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0"> 
                                <thead>
                                    <tr class="text-center text-primary font-weight-bold font-size-12">
                                        <th colspan="2">
                                            <a class="bx-tada float-start" @click="tabIndex--"><i class='bx bx-chevrons-left' ></i></a>
                                            {{semester.year_level}}
                                            <a class="bx-tada float-end" @click="tabIndex++"><i class='bx bx-chevrons-right'></i></a>
                                        </th>
                                    </tr>
                                    <tr class="text-center font-size-11">
                                        <th v-for="(s,index2) in semester.semesters" v-bind:key="index2" v-if="index2 !== 2">
                                            {{s.semester}}
                                            <i @click="add(index,index2)" v-if="s.courses.length > 0" class='bx bxs-plus-circle float-end h4 mb-0 text-muted' style="cursor: pointer;"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" style="width: 50%;" v-for="(s,index2) in semester.semesters" v-bind:key="index2" v-if="index2 !== 2">
                                            <div class="col-md-12" v-for="(course, index3) in s.courses" v-bind:key="'a-'+index3">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <b-form-checkbox v-model="course.is_lab" unchecked-value="not_accepted" checked plain style="font-size: 15px;">
                                                        </b-form-checkbox>
                                                        <b-form-checkbox v-model="course.is_nonacademic" unchecked-value="not_accepted" checked plain style="font-size: 15px;">
                                                        </b-form-checkbox>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm" v-model="course.code" placeholder="Course code" style="text-transform: capitalize;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm" v-model="course.name" placeholder="Course/Subject" style="text-transform: capitalize; margin-left: -15px; width: 110%;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control form-control-sm" v-model="course.unit" placeholder="Unit" style="text-transform: capitalize;">
                                                                </div>
                                                            </div>
                                                            <div @click="rmv(index,index2,index3)"  class="col-md-2" style="margin-left: -18px; cursor: pointer;"><i class='bx bx-trash h5 text-warning' style="margin-top: 4px;"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <i @click="add(index,index2)" v-if="s.courses.length == 0" class='bx bxs-plus-circle h1 text-muted' style="cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                        <tr class="text-center font-size-11">
                                        <th colspan="2" v-for="(s,index2) in semester.semesters" v-bind:key="index2" v-if="index2 === 2">
                                            {{s.semester}}
                                            <i @click="add(index,index2)" v-if="s.courses.length > 0" class='bx bxs-plus-circle float-right h4 mb-0 text-muted' style="cursor: pointer;"></i>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center" style="width: 50%;" v-for="(s,index2) in semester.semesters" v-bind:key="index2" v-if="index2 === 2">
                                            <div class="col-md-6 mx-auto" v-for="(course, index3) in s.courses" v-bind:key="'a-'+index3" style="margin-bottom: -10px;">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <b-form-checkbox v-model="course.is_lab" unchecked-value="not_accepted" checked plain style="font-size: 15px;">
                                   
                                                        </b-form-checkbox>
                                                         <b-form-checkbox v-model="course.is_nonacademic" unchecked-value="not_accepted" checked plain style="font-size: 15px;">
                                   
                                                        </b-form-checkbox>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm" v-model="course.code" placeholder="Course code" style="text-transform: capitalize;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm" v-model="course.name" placeholder="Course/Subject" style="text-transform: capitalize; margin-left: -15px; width: 110%;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control form-control-sm" v-model="course.unit" placeholder="Unit" style="text-transform: capitalize;">
                                                                </div>
                                                            </div>
                                                            <div @click="rmv(index,index2,index3)"  class="col-md-2" style="margin-left: -18px; cursor: pointer;"><i class='bx bx-trash h5 text-warning' style="margin-top: 4px;"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <i @click="add(index,index2)" v-if="s.courses.length == 0" class='bx bxs-plus-circle h1 text-muted' style="cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </b-tab>
                </b-tabs>

            </div>
        </b-form>
    </b-modal>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                editable: false,
                prospectus: {},
                course: {},
                years: ['First Year', 'Second Year', 'Third Year', 'Fourth Year','Fifth Year'],
                lists: [{
                    code: '',
                    subject: '',
                    unit: '',
                    is_lab: false,
                    is_nonacademic: false,
                }],
                semesters: [],
                total: '',
                a: '',  
                tabIndex: 0
            }
        },

        computed : {
            updated: function () {
                return this.semesters;
            }
        },

        methods : {
            set(prospectus,course){
                this.prospectus = prospectus;
                this.course = course;
                if(typeof this.prospectus.subjects === 'string'){
                    this.semesters = JSON.parse(this.prospectus.subjects);
                }else{
                    this.semesters = this.prospectus.subjects;
                }
            },

            add(one,two){
                //      {{semesters[0].semesters[0].courses}}
                this.semesters[one].semesters[two].courses.push({code: '',name: '',unit: ''})
            },

            rmv(one,two,three){
                // this.lists.splice(index, 1);
                this.semesters[one].semesters[two].courses.splice(three,1);
            },

            chck(index){
                this.a = index;
            },

            save(){
                axios.post(this.currentUrl + '/request/prospectus/store',{
                    id: this.prospectus.id,
                    subjects: this.updated,
                    editable: true
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

        }, components : { Multiselect}
    }
</script>
<style>
.nav-tabs {
    display: none;
}
</style>
