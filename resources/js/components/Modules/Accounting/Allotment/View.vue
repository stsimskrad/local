<template>
    <div class="row">

        <div class="col-md-12">
            <blockquote class="p-3 border-light border rounded ">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="font-size-13 text-primary"> <span class="font-size-12 text-muted mb-0">Check #: </span>{{ allotment.check_no }}</h5>
                        <h5 class="font-size-13"> <span class="font-size-12 text-muted mb-0">Checked Date: </span>{{ allotment.checked_at }}</h5>
                    </div>
                    <div class="col-md-4">
                        <h5 class="font-size-13"> <span class="font-size-12 text-muted mb-0">Code: </span>{{ allotment.code }}</h5>
                        <h5 class="font-size-13"> <span class="font-size-12 text-muted mb-0">Credited Date: </span>{{ allotment.credited_at }}</h5>
                    </div>
                    <div class="col-md-4">
                        <router-link :to="{name: 'allotments'}" class="waves-effect float-end"><button style="margin-top: 5px;" type="button"  class="btn btn-light waves-effect waves-light me-2"><i class='bx bx-left-arrow-circle'></i></button></router-link>
                        <button @click="addnew" style="margin-top: 5px;" type="button"  class="btn btn-danger waves-effect waves-light me-2 float-end"><i class='bx bx-plus-medical'></i></button>
                    </div>
                </div>
            </blockquote>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap">
                    <thead class="table-light font-size-11">
                        <tr>
                            <th style="width: 2%;"></th>
                            <th>Expense</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Added By</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="list in allotment.lists" v-bind:key="list.id">
                            <td>
                            
                            </td>
                            <td>{{list.expense.name}}</td>
                            <td class="text-center">₱{{formatPrice(list.amount)}}</td>
                            <td class="text-center font-size-11">{{list.user.profile.firstname}} {{list.user.profile.lastname}}</td>
                            <td class="text-center">{{list.created_at}}</td>
                            <td class="text-center">
                                <a class="me-3 text-warning" @click="edit(list)"><i class='bx bx-edit-alt'></i></a>
                                <a class="text-danger"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Create :expenses="expenses" :allotmentid="id" @status="message" ref="create"/>
    </div>
</template>

<script>    
    import Create from './CreateSub.vue'
    export default {
        props: ['expenses'],
        data(){
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.height,
                pagination: {},
                keyword: '',
                errors: [], 
                expenses: [],
                allotment: {},
                id : this.$route.params.id,
                editable : false
            }
        },

        created(){
            this.fetch();
        },

        computed: {
            total() {
                return this.allotment.lists.reduce((a, req) => {
                    this.tot = parseInt(a) + parseInt(req.amount.replace(/,/g, ''));
                    return this.tot;
                }, 0);
            }
        },

        methods : {
            fetch(){
                axios.get(this.currentUrl + '/request/accounting/allotment/'+this.$route.params.id)
                .then(response => {
                    this.allotment = response.data.data;
                })
                .catch(err => console.log(err));
            },

            addnew(){
                this.$bvModal.show("create");
                this.$refs.create.clear();
            },

            edit(list){
                this.editable = true;
                this.$bvModal.show("create");
                this.$refs.create.edit(list,true);
            },

            message(list){
                if(list){
                    if(this.editable == true){
                        let index = this.allotment.lists.findIndex(u => u.id === list.id);
                        this.$set(this.allotment.lists, index, list);
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                    }else{
                        this.allotment.lists.unshift(list);
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-right'
                        });
                    }
                    this.$bvModal.hide("create");
                    this.editable = false;
                }
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }, components : { Create }
    }
</script>