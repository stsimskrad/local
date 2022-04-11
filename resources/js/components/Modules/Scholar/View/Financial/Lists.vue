<template>
<div>
    <div class="row mb-2">
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
                <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
                <li class="list-inline-item d-none d-sm-inline-block">
                    <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                        <i class='bx bx-chevron-left font-size-16'></i>
                    </a>
                </li>
                <li class="list-inline-item d-none d-sm-inline-block">
                    <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                        <i class='bx bx-chevron-right font-size-16'></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-nowrap">
            <thead class="thead-light">
                <tr class="font-size-11">
                    <th class="text-center">Academic Year</th>
                    <th class="text-center">Session Type</th>
                    <th class="text-center">Release Type</th>
                    <th class="text-center">Disbursement Voucher</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Created at</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="financial in financials" v-bind:key="financial.id">
                    <td class="text-center">{{financial.group.academic_year}}</td>
                    <td class="text-center">{{financial.group.session_type}}</td>
                    <td class="text-center">
                        <span v-if="financial.group.release_type == 'Full'" class="badge bg-success">{{financial.group.release_type}}</span>
                        <span v-else class="badge bg-warning">{{financial.group.release_type}}</span>
                    </td>
                    <td class="text-center">{{(financial.dv_no == null) ? 'n/a' : financial.dv_no}}</td>
                    <td class="text-center">₱{{formatPrice(financial.total)}}</td>
                    <td class="text-center">{{ financial.created_at }}</td>
                    <td class="text-right"><button @click="view(financial)" type="button" class="btn btn-primary btn-sm waves-effect waves-light">View</button></td>
                </tr>
                <!--<tr>
                    <td colspan="5" class="text-right"></td>
                    <td class="text-right"><span class="font-weight-bold text-warning mr-3">Total :</span><b>₱1397.00</b></td>
                </tr>-->
            </tbody>
        </table>
    </div>
    <Create :dropdowns="dropdowns"/>
    <Show ref="view"/>
</div> 
</template>

<script>
    import Create from './Modals/Create.vue';
    import Show from './Modals/View.vue';
    export default {
        props: ['id','counts','height','dropdowns'],
        data(){
            return {
                currentUrl: window.location.origin, 
                keyword: '',
                pagination : {},
                financials: []
            }
        },

        created(){
            this.fetch();
        },

        methods : {
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },

            fetch(page_url){
                 let vm = this, key;
                // (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                page_url = page_url || this.currentUrl + '/request/scholar/financial/'+this.id+'/'+this.counts;

                axios.get(page_url)
                .then(response => {
                    this.financials = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            addnew(){
                this.$bvModal.show("create");
            },

            view(financial){
                this.$refs.view.set(financial);
                this.$bvModal.show("view");
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }, components : { Create, Show }
    }
</script>