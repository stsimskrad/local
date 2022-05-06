<template>
    <div>
        <div class="card-body" v-if="lists.length == 0" :style="{ height: (height - 475) + 'px' }">
           
        </div>
        <div v-else class="card-body border-bottom">
            <div class="page-title-left mt-n2 ms-n3 mb-n3">
                <ol class="breadcrumb m-0 font-size-15">
                    <li>
                        <div class="avatar-xs me-3 mb-n2 mt-n1">
                            <div class="avatar-title bg-transparent rounded">
                                <i class="bx bxs-folder font-size-24 text-info"></i>
                            </div>
                        </div>
                    </li>
                    <li class="breadcrumb-item fw-bold ms-n2">Academic Years</li>
                </ol>
            </div>

            <div class="float-end mt-n4">
                 <form class="mt-n1 float-sm-end d-flex align-items-center">
                    <div class="search-box">
                        <div class="position-relative">
                            <input type="text" class="form-control bg-light border-light rounded"
                                placeholder="Search..." v-model="keyword" @keyup="fetch()"/>
                            <i class="bx bx-search-alt search-icon"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body" :style="{ height: (height-63) + 'px' }">
            <div class="row">
                <div class="col-xl-4 col-sm-6" style="cursor: pointer;" v-for="list in lists" v-bind:key="list.id">
                    <div class="card shadow-none border">
                        <div class="card-body p-3">
                            <div @click="view(list)" class="">
                                <div class="avatar-xs me-3 mb-2">
                                    <div class="avatar-title bg-transparent rounded">
                                        <i class="bx bxs-folder font-size-24 text-warning"></i>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="overflow-hidden me-auto">
                                        <h5 class="font-size-14 text-truncate mb-0">
                                            <a class="text-body">{{ list.academic_year }}</a>
                                        </h5>
                                        <p class="text-muted text-truncate mb-0">
                                            {{ list.semester.name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['height'],
        data() {
            return {
                currentUrl: window.location.origin,
                pagination: {},
                lists: [],
                keyword: ''
            }
        },

        created() {
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

            fetch() {
                let key;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                axios.get(this.currentUrl + '/request/benefit/lists/'+key)
                .then(response => {
                    this.lists = response.data.data;
                    this.makePagination(response.data, response.data.links);
                })
                .catch(err => console.log(err));
            },

            view(data){
                this.$emit('status', data);
            }
        }
    }

</script>
