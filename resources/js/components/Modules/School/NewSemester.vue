<template>
    <b-modal @ok="create($event)" id="newSemester" ok-title="Confirm" title="New Semester" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-6">
                    <label>Year From: <span v-if="errors.from" class="haveerror">({{ errors.from[0] }})</span></label>
                    <date-picker
                        v-model="semester.from"
                        type="year" format="YYYY"
                        lang="en"
                        placeholder="Select Year"
                        :clearable="false"
                        >
                    </date-picker>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                        <label>Academic Year: <span v-if="errors.academic_year" class="haveerror">({{( errors.academic_year[0] )}})</span></label>
                        <input type="text" class="form-control" v-model="academic_year" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <label>Semester: <span v-if="errors.semester_id" class="haveerror">({{( errors.semester_id[0] )}})</span></label>
                    <multiselect v-model="semester.semester" id="ajax" label="name" track-by="id"
                        placeholder="Select Semester" open-direction="bottom" :options="semesters"
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-md-6">
                    <label>Start At: <span v-if="errors.start_at" class="haveerror">({{ errors.start_at[0] }})</span></label>
                    <date-picker
                        v-model="semester.start"
                        type="month" format="YYYY-MM-DD"
                        lang="en"
                        placeholder="Select Month"
                        >
                    </date-picker>
                </div>
                <div class="col-md-6">
                    <label>End At: <span v-if="errors.end_at" class="haveerror">({{ errors.end_at[0] }})</span></label>
                    <date-picker
                        v-model="semester.end"
                        type="month" format="YYYY-MM-DD"
                        lang="en"
                        placeholder="Select Month"
                        >
                    </date-picker>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['dropdowns'],
        components : {DatePicker, Multiselect},
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                semester: {
                    from: '',
                    to: '',
                    start: '',
                    end: '',
                    semester: ''
                },
                id: '',
                editable: false,
            }
        },

        computed : {
            semesters : function() {
                return this.dropdowns.filter(x => x.classification === 'Semester');
            },

            academic_year : function(){
                if(this.semester.from != ''){
                    return new Date(this.semester.from).getFullYear()+'-'+ (Number(new Date(this.semester.from).getFullYear())+1);
                }else{
                    return '';
                }
            }
        },

        methods : {
            set(data,id){
                this.semester.year = data;
                this.id = id;
            },

            create(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/school/semester/store',{
                    school_id: this.id,
                    academic_year: (this.semester.from) ? this.academic_year : '',
                    start_at: (this.semester.start != '') ? new Date(this.semester.start).toLocaleDateString("af-ZA") : '',
                    end_at: (this.semester.start != '') ? new Date(this.semester.end).toLocaleDateString("af-ZA"): '',
                    semester_id: this.semester.semester.id,
                    editable: false
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.type = '';
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
        },
    }
</script>


