<template>
    <div>
        <div class="card-body border-bottom">
            <div class="page-title-left mt-n2 ms-n3 mb-n3">
                <ol class="breadcrumb m-0 font-size-15">
                    <li class="breadcrumb-item fw-bold">{{ selected.academic_year }}</li>
                    <li class="breadcrumb-item active"><span>{{selected.level }}</span></li>
                    <li class="breadcrumb-item active"><span class="fw-bold text-primary">{{selected.semester }}</span></li>
                </ol>
            </div>
             <div class="float-end mt-n2">
                <button @click="back" type="button" class="mt-n4 btn btn-sm btn-label btn-secondary"><i class="bx bxs-chevrons-left label-icon"></i> Back </button>
            </div>
        </div>

        <div class="card-body" :style="{ height: (height-119) + 'px' }">
            <div class="table-responsive">
                <table class="table table-centered table-bordered table-nowrap mb-0">
                    <thead class="thead-light">
                        <tr class="font-size-11">
                            <th style="width: 5%;" class="text-center">#</th>
                            <th style="width: 15%;" class="text-center">Code</th>
                            <th class="text-center" style="width: 60%;">Subject</th>
                            <th class="text-center" style="width: 10%;">Unit</th>
                            <th class="text-center" style="width: 10%;">Grade</th>
                        </tr>
                    </thead>
                </table>
                <simplebar class="align-items-center d-flex justify-content-center"
                    :style="{ height: (height - 240) + 'px' }">
                    <table class="table table-centered table-bordered table-nowrap">
                        <tbody class="font-size-11">
                            <tr v-for="(list,index) in lists" v-bind:key="list.id" :class="[(list.grade == 5 || list.grade == 'F' || list.grade == 'f') ? 'table-danger' : '']">
                                <td style="width: 5%;" class="text-center">{{ index+1 }}</td>
                                <td style="width: 15%;" class="text-center fw-bold">{{list.code}} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td style="width: 60%;" class="text-center">{{list.subject}} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td style="width: 10%;" class="text-center">{{list.unit}}</td>
                                <td style="width: 10%;" class="text-center">
                                    <input type="text" v-model="list.grade" :disabled="selected.is_locked == 1" class="text-center mt-n1 mb-n2 form-control form-control-sm" style="text-transform: uppercase">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </simplebar>
                 <table class="table table-centered table-bordered table-nowrap mb-0">
                    <tfoot class="thead-light">
                        <tr class="font-size-12">
                            <th style="width: 80%;" colspan="3"></th>
                            <th class="text-center text-primary" style="width: 10%;">{{ units }}</th>
                            <th class="text-center text-primary" style="width: 10%;">{{ total }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-body border-top" style="padding: 12px;">
            <div class="table-responsive" style="margin-top: -12px; margin-bottom: -27px;">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td colspan="2" class="border-0">
                                <a v-if="selected.is_locked == 1" href="javascript: void(0);" class="text-dark fw-medium"><i class="mdi mdi-file-document font-size-16 align-middle text-primary me-1"></i> index.html</a>
                                <input v-if="selected.is_locked == 0" multiple ref="fileupload" type="file" @change="uploadFieldChange" class="form-control form-control-sm float-end" :class="[(errors['files.'+0]) ? 'text-danger' : '']" style="width: 250px;" id="formFileSm"/>
                                <b-button v-if="selected.is_locked == 0" @click="locked(selected.id)" type="button" class="btn-sm" variant="primary">
                                    <i class="bx bxs-lock-alt "></i>
                                </b-button>
                                <b-button v-if="selected.is_locked == 0" @click="save" type="button" class="btn-sm w-lg" variant="primary">Save</b-button>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
         <Confirm @status="message" ref="confirm"/>
    </div>
</template>

<script>
    import Confirm from "../Modals/Confirm.vue";
    import Swal from "sweetalert2";
    import simplebar from "simplebar-vue";
    export default {
        components: { simplebar, Swal, Confirm },
        props: ['height','lists','selected','user'],
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                attachments: []
            }
        },

        computed: {
            units: function () {
                var sum = 0;
                if(this.lists != undefined){
                    this.lists.forEach(e => {
                        sum += Number(e.unit);
                    });
                }
                return sum
            },

            total: function () {
                var sum = 0; var tot = 0;
                if(this.lists != undefined){
                    this.lists.forEach(e => {
                        if(e.is_nonacademic == false){
                            tot++;
                            if(e.grade == 'F' || e.grade == 'f'){

                            }else{
                                sum += Number(e.grade);
                            }
                        }
                    });
                }
                return (sum/tot).toFixed(3);
            },

            failed: function(){
                var count = 0;
                this.lists.forEach(e => {
                    if(e.grade == 'F' || e.grade == 'f' || e.grade > 3){
                        count = count + 1;
                    }
                });
                return count;
            }
        },

        methods: {
            uploadFieldChange(e) {
                e.preventDefault();
                var files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.attachments.push(files[i]);
                }
            },

            save(evt) {
                evt.preventDefault();

                let data = new FormData();
                if(this.attachments.length > 0){
                    for (var i = this.attachments.length - 1; i >= 0; i--) {
                        data.append('files[]', this.attachments[i]);
                    }
                }else{
                    data.append('files[]', []);
                }
                data.append('enrollment_id', (this.selected != undefined) ? this.selected.id : '');
                data.append('scholar_id', (this.user != undefined) ? this.user : '');
                data.append('lists', (this.lists.length != 0) ? JSON.stringify(this.lists) : '');
                data.append('file_type', 'grade');

                axios.post(this.currentUrl + '/request/evaluation/grading/store', data)
                .then(response => {
                    this.attachments = [];
                    this.$refs.fileupload.value=null;
                    this.$emit('status', response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        Vue.$toast.warning('<strong>Please attach a copy of your grades</strong>', {
                            position: 'bottom-right'
                        });
                    }
                });
            },

            locked(id){
                this.$bvModal.show("confirm");
                this.$refs.confirm.set(id);
            },
    
            message(list){
                this.prospectus.is_locked = list.is_locked;
                this.$bvModal.hide("confirm"); 
                this.$emit('status', list);  
            },

            back(){
                this.$parent.set('prospectus');
            }
        }
    }

</script>
