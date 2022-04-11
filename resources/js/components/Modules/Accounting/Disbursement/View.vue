<template>
    <b-modal id="view" title="View Disbursement" hide-footer centered>
        <div class="text-center">
            <p class="font-16 text-muted mb-2"></p>
            <h5 class="text-dark">{{list.expense_id.name }}</h5>
            <h4 class="text-info font-16">₱ {{ list.amount }}</h4>
            <p class="text-muted">{{ list.remarks }}</p>
            <div class="float-end ms-2" >
                <p class="font-size-11"><i class="bx bx-calendar text-primary font-size-12 align-middle me-1"></i> {{list.created_at}}</p>
            </div>
            <p class=" float-start font-size-12 mb-0">
                <i class="bx bx-user-circle text-primary font-size-12 align-middle me-1"></i>{{ list.added_by }}
            </p>
        </div>
    </b-modal>
</template>


<script>
    export default {
        data(){
            return {
                list: {
                    expense_id : ''
                }
            }
        },

        methods : {
            set(list){
                this.list = list;
            }
        }
    }
</script>