<template>
    <b-modal @ok="generate($event)"  id="print" ok-title="Generate" modal-ok="Generate" title="Print Reports" centered>
        <div class="row p-2">
            <div class="col-md-12">
                <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-warning">You can filter by using the dropdown. Can be Empty</div>
            </div>
            <div class="col-md-12" v-if="type == 'scholars'">
                <multiselect 
                    v-model="status" 
                    id="ajax" 
                    label="name" track-by="id"
                    placeholder="Select Status" 
                    open-direction="bottom" 
                    :options="statuses"
                    :searchable="true" 
                    :allow-empty="true"
                    :show-labels="false">
                </multiselect> 
            </div>
            <div class="col-md-12 mt-2 mb-2" v-if="type == 'scholars'">
                <multiselect 
                    v-model="program" 
                    id="ajax" 
                    label="name" track-by="id"
                    placeholder="Select Category" 
                    open-direction="bottom" 
                    :options="programs"
                    :searchable="true" 
                    :allow-empty="true"
                    :show-labels="false">
                </multiselect> 
            </div>
            <div class="col-md-6" style="padding-right: 5px;">
                <date-picker
                    v-model="from"
                    type="year" format="YYYY"
                    lang="en"
                    placeholder="From Year"
                    :clearable="false"
                    >
                </date-picker>
            </div>
            <div class="col-md-6" style="padding-left: 5px;">
                <date-picker
                    v-model="to"
                    type="year" format="YYYY"
                    lang="en"
                    placeholder="To Year"
                    :clearable="false"
                    >
                </date-picker>
            </div>
        </div>
    </b-modal>
</template>
<script>
    import DatePicker from "vue2-datepicker";
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['dropdowns','programs'],
        components : { Multiselect, DatePicker },
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                type: '',
                status: '',
                program: '',
                from: '',
                to: ''
            }
        },

        computed:{
            statuses : function() {
                return this.dropdowns.filter(x => x.classification === 'Status');
            }
        },

        methods : {
            set(type){
                this.status = ''; this.program = ''; this.from = ''; this.to = '';
                this.type = type;
                if(type != 'scholars'){
                    let t = this.statuses.filter(x => x.name === 'Graduated');
                    this.status = t[0]; 
                }
            },

            generate(){
                let info = {
                    'status' : (this.status != '' && this.status != null) ? this.status.id : '',
                    'program' : (this.program != '' && this.program != null) ? this.program.id : '',
                    'from' : (this.from != '') ? new Date(this.from).toLocaleDateString("af-ZA") : '',
                    'to' : (this.to != '') ? new Date(this.to).toLocaleDateString("af-ZA") : '',
                    'type' : this.type
                };
                info = JSON.stringify(info);
                window.open(this.currentUrl + '/request/scholar/reports/scholars/generate/'+info);
            }
        }
    }
</script>





