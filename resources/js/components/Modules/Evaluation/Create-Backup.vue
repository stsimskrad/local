<template>
    <b-form class="customform">
        <div class="card-body border-bottom" style="padding: 17px;">
            <div class="row">
                <div class="col-md-4">
                    <label>Level: <span v-if="errors.level_id" class="haveerror">({{ errors.level_id[0] }})</span></label>
                    <multiselect v-model="info.level" id="ajax" label="others" track-by="id"
                        placeholder="Select Level" open-direction="bottom" :options="levels"
                        :allow-empty="false"
                        @input="onChange()"
                        :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-md-8">
                    <label>Semester: <span v-if="errors.semester_id" class="haveerror">({{ errors.semester_id[0] }})</span></label>
                    <multiselect v-model="info.semester" id="ajax"
                        placeholder="Select Semester" open-direction="bottom" :options="semesters"
                        :allow-empty="false"
                        @input="onChange()"
                        :custom-label="nameWithLang"
                        :show-labels="false">
                    </multiselect> 
                </div>
            </div>
        </div>
        <div class="card-body border-bottom">
            <div class="table-responsive mt-3">
                <simplebar class="align-items-center d-flex justify-content-center" :style="{ height: (height - hayt) + 'px' }">
                    <table class="table table-bordered mb-0">
                        <tbody class="text-center font-size-11 " >
                            <tr class="align-middle" v-for="list in lists" v-bind:key="list.id" style="line-height: 10px;">
                                <td @click="swtch(list)" style="cursor: pointer; width: 7%;">
                                    <i v-if="list.is_lab == true" class='bx bx bxs-flask h5 mb-n2 text-warning'></i>
                                    <i v-else class='bx bxs-book-open  h5 mb-n2 text-info'></i>
                                </td>
                                <td class="fw-bold">{{ list.code }} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td>{{ list.subject }} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td style="width: 9.5%;">{{ list.unit }}</td>
                            </tr>
                        </tbody>
                    </table>
                </simplebar>
                <table class="table table-bordered mb-0"> 
                    <tbody class="text-center font-size-11">
                        <tr v-if="total > 0">
                            <td>
                            </td>
                            <td style="width: 9.5%;" class="fw-bold text-success">{{ total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body" style="padding: 12px;">
            <div>
                <div v-if="custom == false">
                    <b-button type="button" @click="create" class="float-end btn-sm w-lg" variant="primary">Create</b-button>
                    <b-button type="button" @click="cstm" class="float-end btn-sm w-lg me-2" variant="light">Custom</b-button>
                    <b-button type="button" @click="add1" class="float-end btn-sm w-lg me-2" variant="light">Add</b-button>
                    
                    <input multiple type="file" @change="uploadFieldChange" class="form-control form-control-sm" :class="[(errors['files.'+0]) ? 'text-danger' : '']" style="width: 380px;" id="formFileSm"/>
                </div>
                <div v-else>
                    <b-button type="button" @click="custom = false" class="float-end btn-sm w-lg" variant="primary">Close</b-button>
                    <b-button type="button" @click="add" class="btn-sm w-lg" variant="light">Add Subject</b-button>
                </div>
            </div>
        </div>
        <Swch @status="message" ref="swtch"/>
        <Custom @add="addsubject" ref="custom"/>
        <Add @add="addsubject" ref="failed" />
        <Create @err="err" @status="res" :class_type="class_type" :enrollments="enrollments" ref="create"/>
    </b-form>
</template>

<script>
    import Create from "./Modals/Create.vue";
    import Add from "./Modals/Add.vue";
    import Swch from "./Modals/Switch.vue";
    import Custom from "./Modals/Custom.vue";
    import DatePicker from "vue2-datepicker";
    import Multiselect from 'vue-multiselect';
    import simplebar from "simplebar-vue";
    export default {
        props: ['user','dropdowns','academic_year','height', 'level', 'pros', 'class_type','enrollments'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                info: {
                    academic_year: new Date().getFullYear()+'-'+ (new Date().getFullYear()+1),
                    level: '',
                    semester: '',
                    subcourse: '',
                },
                semesters: [],
                prospectus: {},
                lists: [],
                customs: [],
                subjects: [],
                attachments: [],
                propec: {},
                custom: false,
                editable: false
                
            }
        },

        created(){
            this.info.level = this.level;
            // this.info.subcourse = (this.subcourse != null) ? this.subcourse : ''; 
            this.prospec = JSON.parse(this.pros);
        },

        computed : {
            levels : function() {
                return this.dropdowns.filter(x => x.classification === 'Level');
            },
            total: function() {
                var sum = 0;
                if(this.lists != undefined){
                    this.lists.forEach(e => {
                        sum += Number(e.unit);
                    });
                }
                return sum
            },
            hayt: function() {
                if(this.lists.length > 0){
                    return 331;
                }else{
                    return 289;
                }
            }
        },

        methods : {
            nameWithLang ({ academic_year,semester }) {
                return `${academic_year} — ${semester.name}`
            },

            uploadFieldChange(e) {
                e.preventDefault();
                var files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.attachments.push(files[i]);
                }
            },

            create(){
                let data = new FormData();
                if(this.attachments.length > 0){
                    for (var i = this.attachments.length - 1; i >= 0; i--) {
                        data.append('files[]', this.attachments[i]);
                    }
                }else{
                    if(this.editable == false){
                        data.append('files[]', []);
                    }
                }
                data.append('semester_id', (this.info.semester.id != undefined) ? this.info.semester.id : '');
                data.append('level_id', (this.info.level.id != undefined) ? this.info.level.id : '');
                data.append('scholar_id', (this.user != undefined) ? this.user : '');
                data.append('lists', (this.lists.length != 0) ? JSON.stringify(this.lists) : '');
                data.append('file_type', 'enrollment');
                data.append('editable', this.editable);

                this.$bvModal.show("create");
                this.$refs.create.set(data);
            },

            onChange(){
                this.errors = []; this.subjects = []; this.customs = [];
                if(this.prospec != null){
                    let one, two, three, four;
                    one = this.prospec;
                    two = one.prospectus;
                    three = two.filter(x => x.year_level === this.info.level.others);
                    four = three[0].semesters.filter(x => x.semester === this.info.semester.semester.name);
                    this.prospectus = Object.assign({},four[0]);
                    this.lists = this.prospectus.courses;

                    two.forEach((item) => {
                        item.semesters.forEach((it) => {
                            it.courses.forEach((i) => {
                                if(!i.hasOwnProperty("grade")){
                                    this.subjects.push(i);
                                }
                                this.customs.push(i);
                            });
                        });
                    });
                }
            },

            fetchSemesters(school,awarded_year){
                axios.get(this.currentUrl + '/request/school/semester/'+school+'/'+awarded_year)
                .then(response => {
                    this.semesters = response.data;
                })
                .catch(err => console.log(err));
            },

            swtch(selected){
                this.$refs.swtch.set(this.subjects,selected,this.user);
                this.$bvModal.show("switch");
            },

            cstm(){
                this.custom = true;
                this.lists = [];
                this.$refs.custom.set(this.customs);
            },

            add1(){
                this.$bvModal.show("failedSubject");
                this.$refs.failed.set(this.customs);
            },

            add(){
                this.$bvModal.show("customy");
            },

            message(list){
                this.$bvModal.hide("switch");
                this.prospec = list.information;
                this.subjects = [];
                this.onChange();
            },

            err(err){
                this.errors = err;
            },

            addsubject(list){
                this.lists.push(list);
            },

            res(data){
                this.$emit('status', data);
            }
        }, components : { Multiselect, simplebar, DatePicker, Swch, Custom, Add, Create }
    }
</script>


