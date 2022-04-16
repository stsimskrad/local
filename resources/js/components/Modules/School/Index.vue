<template>
    <div>
       <div class="row mb-3">
            <div class="col-xl-6 col-sm-6 d-inline-block">
                <form class="d-inline-block ">
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
                    <tr class="font-size-12">
                        <th style="width: 2%;"></th>
                        <th>Name</th>
                        <th class="text-center">Class</th>
                        <th class="text-center">Term</th>
                        <th class="text-center">Grading</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <tr v-for="list in lists" v-bind:key="list.id">
                        <td>
                            <div class="avatar-xs">
                                <span class="avatar-title rounded-circle">{{list.name.charAt(0)}}</span>
                            </div>
                        </td>
                        <td>
                            <h5 class="font-size-13 mb-0 text-dark">{{list.name}} - {{list.campus}}</h5>
                            <p class="font-size-12 text-muted mb-0">{{list.address}}, {{list.municipality.name}}</p>
                        </td>
                        <td class="text-center">{{list.class.name}}</td>
                        <td class="text-center">{{list.term.name}}</td>
                        <td class="text-center">{{list.grading.name}}</td>
                        <td class="text-center">
                            <router-link :to="{ path: '/school/'+list.code }" class="mr-3">
                                <i class='bx bx-sitemap'></i>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
     
    </div>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            counts: this.$parent.$parent.$parent.$parent.counts,
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
            let vm = this; let key,s,c,y;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            (this.category != '' && this.category != null) ? c = this.category : c = '-';
            (this.year != '' && this.year != null) ? y = this.year : y = '-';
            page_url = page_url || this.currentUrl + '/request/school/lists/'+key+'/'+this.counts;

            axios.get(page_url)
            .then(response => {
                this.lists = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        }
    }
}
</script>