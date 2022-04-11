<template>
<div>
    <div class="row mb-3">
        <div class="col-xl-6 col-sm-6 d-inline-block">
            <button type="button" @click="addnew" class="btn btn-danger waves-effect waves-light me-1" style="margin-top: -2px;"><i class='bx bx-plus-medical'></i></button>
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
                    <th style="width: 30%;">Title of Award</th>
                    <th class="text-center" style="width: 24%;">Awarding Body</th>
                    <th class="text-center" style="width: 23%;">Date Given</th>
                    <th class="text-center" style="width: 23%;">Date Added</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="info in infos" v-bind:key="info.id">
                    <td>{{info.information.award}}</td>
                    <td class="text-center">{{info.information.body}}</td>
                    <td class="text-center">{{info.information.given}}</td>
                    <td class="text-center font-size-11">{{info.created_at}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <Award @status="status" :user="id"/>
</div>
</template>

<script>
    import Award from '../Forms/Award.vue';
    export default {
        props: ['id','counts','height'],
        data(){
            return {
                currentUrl: window.location.origin, 
                keyword: '',
                pagination : {},
                infos: [],
                editable : false
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
                page_url = page_url || this.currentUrl + '/request/scholar/tracer/Award/'+this.id+'/'+this.counts;

                axios.get(page_url)
                .then(response => {
                    this.infos = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            addnew(){
                 this.$bvModal.show("award");
            },

            view(financial){
            },

            status(award){
                if(award){
                    if(this.editable == true){
                        let index = this.infos.findIndex(u => u.id === award.id);
                        this.$set(this.infos, index, award);
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                    }else{
                        this.infos.unshift(award);
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-right'
                        });
                    }
                    this.$bvModal.hide("award");
                    this.editable = false;
                }
            }
        }, components : { Award }
    }
</script>