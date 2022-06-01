<template>
    <b-modal @ok="create($event)" id="createD" title="Create Disbursement" ok-title="Save" centered>
        <b-form class="customform mb-2">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Expense: <span v-if="errors.expense_id" class="haveerror">({{ errors.expense_id[0] }})</span></label>
                        <multiselect 
                            v-model="expense_id" 
                            :options="expenses"
                            :show-labels="false"
                            label="name" track-by="id" 
                            :allow-empty="false"
                            placeholder="Select Expense">
                        </multiselect>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Amount: <span v-if="errors.amount" class="haveerror">({{ errors.amount[0] }})</span></label>
                        <input type="text" class="form-control" v-model="amount">
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
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['expenses'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                id: '',
                amount: '',
                expense_id: '',
                remarks: '',
                editable: false,
            }
        },
        
        methods : {
            create(evt){
                evt.preventDefault();
                axios.post(this.currentUrl + '/request/accounting/disbursement/store', {
                    id: this.id,
                    allotment_id: this.allotmentid,
                    expense_id : this.expense_id.id,
                    amount: this.amount,
                    remarks: this.remarks,
                    editable: this.editable,
                    type: 'Lists'
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
                this.expense_id = list.expense_id;
                this.amount = list.amount;
                this.remarks = list.remarks;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                this.errors = [];
                this.id = '';
                this.amount = '';
                this.expense_id = '';
                this.remarks = '';
            },
        }, components : { Multiselect }
    }
</script>