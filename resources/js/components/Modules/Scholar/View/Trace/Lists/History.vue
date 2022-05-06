<template>
<div>
    <div class="row mb-3">
        <div class="col-xl-6 col-sm-6 d-inline-block">
            <button type="button" @click="addnew" class="btn btn-danger me-1" style="margin-top: -2px;"><i class='bx bx-plus-medical'></i></button>
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
                        <i class='bx bx-chevron-left fw-bold font-size-16'></i>
                    </a>
                </li>
                <li class="list-inline-item d-none d-sm-inline-block">
                    <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                        <i class='bx bx-chevron-right fw-bold font-size-16'></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-nowrap">
            <thead class="thead-light">
                <tr class="font-size-11">
                    <th style="width: 30%;">Company</th>
                    <th class="text-center" style="width: 24%;">Position / Period</th>
                    <th class="text-center" style="width: 23%;">Is Job Related To UAT?</th>
                    <th class="text-center" style="width: 23%;">Date Added</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <tr v-for="info in infos" v-bind:key="info.id">
                    <td>
                        <h5 class="font-size-13 mb-0 text-dark">{{info.information.company}}</h5>
                        <p class="font-size-12 text-muted mb-0">{{info.information.address}}</p>
                    </td>
                    <td class="text-center">
                        <h5 class="font-size-13 mb-0 text-dark">{{info.information.position}}</h5>
                        <p class="font-size-12 text-muted mb-0">{{ formDate(info.information.start_at) }} - {{formDate(info.information.end_at) }}</p>
                    </td>
                    <td class="text-center">
                        <i :class="(info.information.is_related) ? 'bx bxs-check-circle text-success' : 'bx bxs-x-circle text-danger'"></i>
                    </td>
                    <td class="text-center font-size-11">
                       {{info.created_at}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <History @status="status" :user="id"/>
</div>
</template>

<script>
    import History from '../Forms/History.vue';
    export default {
        props: ['id','counts','height'],
        data(){
            return {
                currentUrl: window.location.origin, 
                keyword: '',
                pagination : {},
                infos: []
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
                    prev_page_url: links.prev,
                    total: meta.total,
                    per_page: meta.per_page,
                };
                this.pagination = pagination;
            },

            fetch(page_url){
                 let vm = this, key;
                // (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                page_url = page_url || this.currentUrl + '/request/scholar/tracer/History/'+this.id+'/'+this.counts;

                axios.get(page_url)
                .then(response => {
                    this.infos = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            addnew(){
                this.$bvModal.show("history");
            },

            view(financial){
            },

            status(history){
                if(history){
                    if(this.editable == true){
                        let index = this.infos.findIndex(u => u.id === history.id);
                        this.$set(this.infos, index, history);
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                    }else{
                        this.infos.unshift(history);
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-right'
                        });
                    }
                    this.$bvModal.hide("history");
                    this.editable = false;
                }
            },

            formDate(data){
                return new Date(data).toDateString().split(' ').slice(1).join(' ');
            }
        }, components : { History }
    }
</script>