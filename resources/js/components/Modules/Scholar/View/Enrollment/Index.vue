<template>
    <div>
        <div class="row mb-3">
            <div class="col-xl-5 col-sm-5 d-inline-block">
                <form class="d-inline-block ms-1">
                    <div class="search-box">
                        <div class="position-relative">
                            <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                            <i class='bx bx-search-alt search-icon'></i>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-7 col-sm-7 mt-n1">
                <ul class="list-inline user-chat-nav text-end mb-0 dropdown">
                    <li class="list-inline-item d-none d-sm-inline-block font-size-12">
                         {{(pagination.current_page == 1) ? '1' : ((pagination.current_page -1) * pagination.per_page) + 1 }}-{{(pagination.last_page == pagination.current_page) ? pagination.total : pagination.current_page * pagination.per_page }} of {{pagination.total}}
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block">
                        <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                            <i class='bx bx-chevron-left mt-1 h4'></i>
                        </a>
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block">
                        <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                            <i class='bx bx-chevron-right mt-1 h4'></i>
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
                        <th>Name</th>
                        <th class="text-center">Level</th>
                        <th class="text-center">Failed</th>
                        <th class="text-center">No Grades</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created at</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <tr v-for="info in infos" v-bind:key="info.id" style="cursor: pointer;">
                        <td>
                             <i @click="win(info.attachment.enrollments.file)" class='bx bxs-file-pdf font-size-24 mt-1 me-n3' style="cursor: pointer;"></i>
                        </td>
                        <td>
                            <h5 class="font-size-13 mb-0 text-primary">{{ info.academic_year }}</h5>
                            <p class="font-size-11 text-muted mb-0">{{ info.semester }}</p>
                        </td>
                        <td class="text-center">{{ info.level }}</td>
                        <td class="text-center">{{ info.has_failing }}</td>
                        <td class="text-center">{{ info.has_empty }}</td>
                        <td class="text-center">
                            <span v-if="info.is_clear" class="badge bg-success">Completed</span>
                            <span v-else class="badge bg-danger">Not Completed</span>
                        </td>
                        <td class="text-center font-size-11">{{ info.created_at }}</td>
                    </tr>
                    <tr v-if="infos.length == 0">
                        <td class="text-center" colspan="7">
                            No records for scholars
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <WindowPortal v-model="open">
            <HelloWorld :attachment="attachment"/>
        </WindowPortal>
    </div>
</template>

<script>
    import WindowPortal from '../../../Evaluation/Window/WindowPortal.vue';
    import HelloWorld from '../../../Evaluation/Window/HelloWorld.vue';
    export default {
        components : {WindowPortal, HelloWorld},
        props: ['user'],
        data(){
            return {
                currentUrl: window.location.origin, 
                keyword: '',
                pagination : {},
                infos: [],
                editable : false,
                open: false,
                attachment: '',
                keyword: '-'
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
                let vm = this;
                page_url = page_url || this.currentUrl + '/request/evaluation/enrollment/'+this.$route.params.id+'/'+this.keyword;

                axios.get(page_url)
                .then(response => {
                    this.infos = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            win(attachment){
                this.open = true;
                this.attachment = attachment;
            }
        }
    }
</script>