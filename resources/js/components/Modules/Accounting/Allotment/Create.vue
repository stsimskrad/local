<template>
    <b-modal @ok="create($event)" id="createA" title="Create Allotment" ok-title="Save" centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Check #: <span v-if="errors.check_no" class="haveerror">({{ errors.check_no[0] }})</span></label>
                        <input type="text" class="form-control" v-model="check_no">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date Check: <span v-if="errors.checked_at" class="haveerror">({{ errors.checked_at[0] }})</span></label>
                        <date-picker v-model="check" :first-day-of-week="1" lang="en"></date-picker>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date Credited: <span v-if="errors.credited_at" class="haveerror">({{ errors.credited_at[0] }})</span></label>
                        <date-picker v-model="credited" :first-day-of-week="1" lang="en"></date-picker>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Remarks: <span v-if="errors.remarks" class="haveerror">({{ errors.remarks[0] }})</span></label>
                        <input type="text" class="form-control" v-model="remarks">
                    </div>
                </div>
                                            
            </div>
        </b-form>
    </b-modal>
</template>


<script>
    import DatePicker from "vue2-datepicker";
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                id: '',
                check_no: '',
                check: '',
                credited: '',
                remarks: '',
                editable: false,
            }
        },
        
        methods : {
            create(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/accounting/allotment/store', {
                    id: this.id,
                    check_no: this.check_no,
                    checked_at: this.check,
                    credited_at: this.credited,
                    remarks: this.remarks,
                    editable: this.editable,
                    type: 'Allotment'
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            edit(list,editable){
                this.id = list.id;
                this.check_no = list.check_no;
                this.check = list.checked_at;
                this.credited = list.credited_at;
                this.remarks = list.remarks;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                this.errors = [];
                this.id = '';
                this.check_no = '';
                this.check = '';
                this.credited = '';
                this.remarks = '';
            },
        }, components : { DatePicker }
    }
</script>