<template>
    <b-modal id="view" size="lg" title="View" hide-footer centered>
        <b-form class="customform mb-2">
            <div class="table-responsive" v-if="financial.lists.length > 0">
                <table class="table table-nowrap">
                    <thead class="table-light">
                        <tr class="font-size-11">
                            <th class="text-center">Benefit Type</th>
                            <th class="text-center">Flag</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="list in financial.lists" v-bind:key="list.id">
                            <td class="text-center">{{list.benefit.name}}</td>
                            <td class="text-center">{{(list.benefit.name == 'Stipend') ? months[list.flag-1] : 'n/a'}}</td>
                            <td class="text-center">{{list.amount}}</td>
                            <td class="text-center font-size-12">{{list.created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        data(){
            return {
                financial: {
                    lists : {}
                },
                user: '',
                stipends: [],
                counts: this.$parent.counts,
                months: [
                    'January','February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
                ]
            }
        },

        methods : {
            set(financial){
                this.financial = financial;
            },
        }
    }
</script>