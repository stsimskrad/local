<template>
    <div>
        <div class="row mb-3">
            <div class="col-xl-6 col-sm-6 d-inline-block">
                <button type="button" @click="addnew" class="btn btn-danger waves-effect waves-light me-1"><i class='bx bx-plus-medical'></i></button>
                <form class="d-inline-block">
                    <div class="search-box">
                        <div class="position-relative">
                            <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                            <i class='bx bx-search-alt search-icon'></i>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-6 col-sm-6">
                <ul class="list-inline user-chat-nav text-end mb-0 dropdown">
                    <li class="list-inline-item d-none d-sm-inline-block font-size-12">
                        {{(pagination.current_page == 1) ? '1' : ((pagination.current_page -1) * pagination.per_page) + 1 }}-{{(pagination.last_page == pagination.current_page) ? pagination.total : pagination.current_page * pagination.per_page }} of {{pagination.total}}
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block">
                        <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                            <i class='bx bx-chevron-left h4'></i>
                        </a>
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block">
                        <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                            <i class='bx bx-chevron-right h4'></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-centered table-nowrap">
                <thead class="thead-light">
                    <tr class="font-size-11"> 
                        <th style="width: 2%;"></th>
                        <th>Expense</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Added By</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="list in lists" v-bind:key="list.id">
                        <td>
                            
                        </td>
                        <td>{{list.expense_id.name}}</td>
                        <td class="text-center">₱{{formatAmount(list.amount)}}</td>
                        <td class="text-center">{{list.created_at}}</td>
                        <td class="text-center">{{list.added_by}}</td>
                        <td class="text-end">
                            <a class="me-3 text-warning" @click="edit(list)"><i class='bx bx-edit-alt'></i></a>
                            <a class="me-3 text-info" @click="view(list)"><i class='bx bxs-show'></i></a>
                            <a class="text-danger"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Create :expenses="expenses" @status="message" ref="create" />
        <Show ref="view" />
    </div>
</template>


<script>
import Create from './Create.vue';
import Show from './View.vue';
export default {
    props: ['expenses'],
    data(){
        return {
            currentUrl: window.location.origin,
            counts: this.$parent.$parent.$parent.$parent.$parent.$parent.$parent.counts,
            errors: [],
            pagination: {},
            keyword: '',
            lists : [],
        }
    },

    created(){
        this.fetch();
    },

    methods: {
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
                total: meta.total,
                per_page: meta.per_page,
            };
            this.pagination = pagination;
        },

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/accounting/disbursement/';

            axios.get(page_url,{
                params: {  
                    counts : this.counts,
                    keyword : key,
                }
            })
            .then(response => {
                this.lists = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        addnew(){
            this.$bvModal.show("createD");
            this.$refs.create.clear();
        },

        view(list){
            this.$bvModal.show("view");
            this.$refs.view.set(list);
        },

        edit(list){
            this.editable = true;
            this.$bvModal.show("createD");
            this.$refs.create.edit(list,true);
        },

        message(list){
            if(list){
                if(this.editable == true){
                    let index = this.lists.findIndex(u => u.id === list.id);
                    this.$set(this.lists, index, list);
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }else{
                    this.lists.unshift(list);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                }
                this.$bvModal.hide("create");
                this.editable = false;
            }
        },

        formatAmount(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }, components : { Create, Show }
}
</script>