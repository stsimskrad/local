<template>
    <div>
        <div class="row mb-4">
             <div class="col-xl-6">
                <router-link :to="{ name: 'scholar/create' }"> 
                    <button type="button" class="btn btn-sm w-sm mb-n3 btn-outline-light">Create</button>
                </router-link>
                <router-link :to="{ name: 'scholar/import' }">
                    <button type="button" class="btn btn-sm w-sm mb-n3 btn-outline-light">Import</button>
                </router-link>
                <router-link :to="{ name: 'scholar/reports' }">
                    <button type="button" class="btn btn-sm w-sm mb-n3 btn-outline-light">Reports</button>
                </router-link>
            </div>
            <div class="col-xl-6">
                <ul class="list-inline user-chat-nav text-end mb-0 dropdown">
                    <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">     
                       <i class='bx bxs-error-circle bx-tada text-warning h4' style="margin-left: -22px; position: absolute;"></i> <span class="text-muted font-size-11">Incomplete Scholar Information</span>
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block font-size-12">
                         {{(pagination.current_page == 1) ? '1' : ((pagination.current_page -1) * pagination.per_page) + 1 }}-{{(pagination.last_page == pagination.current_page) ? pagination.total : pagination.current_page * pagination.per_page }} of {{pagination.total}}
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block">
                        <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                            <i class='bx bx-chevron-left h4 mb-n4 mt-1 me-n3'></i>
                        </a>
                    </li>
                    <li class="list-inline-item d-none d-sm-inline-block">
                        <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                            <i class='bx bx-chevron-right h4 ms-n3 mb-n4 mt-1 me-n4'></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-xl-12 d-inline-block mb-n3">
                <div class="input-group mb-2" ref="www">
                    <label class="input-group-text bg-light"> <i class='bx bx-search-alt'></i></label>
                    <input type="text" class="form-control" style="width: 55%;" placeholder="Search..." v-model="keyword" @keyup="fetch()"/>
                    <select v-model="is_undergrad" @change="fetch()" class="form-select" :class="(program == null) ? 'text-muted' : ''" style="width: 100px; font-weight: 500;">
                        <option value="all" selected="">All</option>
                        <option value="1">Undergraduate</option>
                        <option value="0">JLSS</option>
                    </select>
                    <select  v-model="program" @change="fetch()" placeholder="Choose Program" class="form-select" :class="(program == null) ? 'text-muted' : ''" style="width: 100px;">
                        <option :value="null" selected>All Program</option>
                        <option :value="program" v-for="program in programs" v-bind:key="program.id">{{ program.name }}</option>
                    </select>
                    <select  v-model="status" @change="fetch()" placeholder="Choose Program" class="form-select" :class="(status == null) ? 'text-muted' : ''" style="width: 100px;">
                        <option :value="null" selected>All Status</option>
                        <option :value="stat" v-for="stat in statuses" v-bind:key="stat.id">{{ stat.name }}</option>
                    </select>
                    <input type="text" class="form-control" style="width: 100px;" placeholder="Enter Year" v-model="year"  @keyup="fetch()"/>
                    <label style="cursor: pointer;" @click="location()" class="input-group-text bg-light"> <i class='bx bxs-map'></i></label>
                    <label style="cursor: pointer;" @click="education()" class="input-group-text bg-light"> <i class='bx bxs-graduation'></i></label>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-centered table-nowrap">
                <thead class="thead-light">
                    <tr class="font-size-11">
                        <th style="width: 2%;"></th>
                        <th>Name</th>
                        <th class="text-center">Program </th>
                        <th class="text-center">Education</th>
                        <th class="text-center">Awarded Year</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">
                            <i class='bx bx-filter h3' style="position: absolute; margin-top: -20px; margin-left: -33px; cursor: pointer;"></i>
                        </th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <tr v-for="user in users" v-bind:key="user.id" style="cursor: pointer;" :class="[(user.is_completed == 0) ? 'table-warnings' : '']">
                        <td>
                            <div class="avatar-xs" v-if="user.profile.avatar == 'n/a'">
                                <span class="avatar-title rounded-circle">{{user.profile.lastname.charAt(0)}}</span>
                            </div>
                            <div v-else>
                                <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+user.profile.avatar" alt="">
                            </div>
                        </td>
                        <td>
                            <h5 class="font-size-13 mb-0 text-dark">{{user.profile.lastname}}, {{user.profile.firstname}} {{user.profile.middlename[0]}}.</h5>
                            <p v-if="user.address.province != undefined" class="font-size-11 text-muted mb-0">{{user.address.name }}</p>
                            <p v-else class="font-size-11 text-muted mb-0">{{user.address.name.toUpperCase() }}</p>
                        </td>
                        <td class="text-center">
                            <h5 class="font-size-13 mb-0 text-dark">{{user.program.name}}</h5>
                            <p class="font-size-11 text-muted mb-0">{{(user.is_undergrad) ? 'Undergraduate' : 'JLSS Program' }}</p>
                        </td>
                        <td class="text-center">
                            <!-- user.education.name }}  {{(user.school == null) ? '' : (user.school.is_main == 1) ? '' : ' - '+user.school.campus }} -->
                            <h5 class="font-size-11 mb-0 text-dark">{{ (user.education.school == 'n/a') ? 'n/a' :  user.education.school.name}}</h5> 
                            <p class="font-size-11 text-muted mb-0">{{ (!Object.keys(user.education.course).includes('name'))  ? user.education.course : user.education.course.name }}</p>
                        </td>
                        <td class="text-center fw-bold text-primary">{{user.awarded_year}}</td>
                        <td class="text-center">
                            <span v-if="user.status.type == 'ongoing'" :class="'badge bg-'+user.status.color">{{user.status.name}}</span>
                            <span v-else :class="'badge badge-pill badge-soft-'+user.status.color">{{user.status.name}}</span>
                        </td>
                        <td class="text-end">
                            <button type="button" @click="update(user)" class="bg-light btn btn-light" v-if="user.is_completed == 0"><i class='bx text-warning bxs-info-circle'></i></button>
                            <router-link :to="{ path: '/scholar/'+user.code }">
                                <button type="button" class="bg-soft-info btn btn-light" style="margin-end: -10px;">
                                    <span class="d-none d-sm-inline-block">  <i class='bx bx-user-circle'></i></span>
                                </button>
                            </router-link>                              
                        </td>
                    </tr>
                    <tr v-if="users.length == 0">
                        <td class="text-center" colspan="7">
                            No records for scholars
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Update :regions="regions" :dropdowns="dropdowns" @status="message" ref="update"/>
        <FilterLocation :regions="regions"  @status="message" ref="filter"/>
        <FilterEducation @status="message" ref="education"/>
    </div>
</template>
<script>
import Update from './Modals/Update.vue';
import FilterLocation from './Modals/FilterLocation.vue';
import FilterEducation from './Modals/FilterEducation.vue';
export default {
    props: ['dropdowns','regions', 'programs'],
    data(){
        return {
            currentUrl: window.location.origin,
            counts: this.$parent.$parent.$parent.$parent.counts,
            errors: [],
            pagination: {},
            keyword: '',
            users : [],
            program: null,
            status: null,
            year: null,
            arr: {},
            arr2: {},
            show: false,
            is_undergrad : 'all',
        }
    },

    created(){
        this.fetch();
    },

    computed:{
        statuses : function() {
            return this.dropdowns.filter(x => x.classification === 'Status');
        }
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

        fetch(page_url) {
            let vm = this; 

            let info = {
                'keyword' : this.keyword,
                'status' : (this.status ==  null) ? null : this.status.id, 
                'program' : (this.program ==  null) ? null : this.program.id, 
                'year' : (this.year === '' || this.year == null) ? '' : this.year,
                'is_undergrad' : this.is_undergrad,
                'counts' : this.counts
            };

            info = (Object.keys(info).length == 0) ? '-' : JSON.stringify(info);
            let location = (Object.keys(this.arr).length == 0) ? '-' : JSON.stringify(this.arr);
            let education = (Object.keys(this.arr2).length == 0) ? '-' : JSON.stringify(this.arr2);

            page_url = page_url || this.currentUrl + '/request/scholar';
            axios.get(page_url,{
                params: {  
                    info : info,
                    location: location,
                    education: education
                }
            })
            .then(response => {
                this.users = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        filter(data,name,type){
            switch(type){
                case 'program':
                    this.program = data;
                    this.$emit('status', 'program', name);
                break;
                case 'status':
                    this.status = data;
                    this.$emit('status', 'status', name);
                break;
            }

            let info = {
                'keyword' :  (this.keyword != '' && this.keyword != null) ? this.keyword : '-',
                'status' : (this.status != '' && this.status != null) ? this.status : '-',
                'program' : (this.program != '' && this.program != null) ? this.program : '-',
                'year' : this.year,
                'counts' : this.counts
            };

            info = (Object.keys(info).length == 0) ? '-' : JSON.stringify(info);
            let location = (Object.keys(this.arr).length == 0) ? '-' : JSON.stringify(this.arr);
            let education = (Object.keys(this.arr2).length == 0) ? '-' : JSON.stringify(this.arr2);
            this.fetch(this.currentUrl + '/request/scholar/'+info+'/'+education+'/'+location);
        },

        update(user){
            this.editable = true;
            this.$refs.update.set(user);
            this.$bvModal.show("update");
        },

        location(){
            this.editable = 'filter';
            this.$bvModal.show("filter");
        },

        education(){
            this.editable = 'education';
            this.$bvModal.show("education");
        },

        yr(){
            (this.show == false) ? this.show = true : this.show = false;
        },

        message(user){
            if(user){
                if(this.editable == true){
                    let index = this.users.findIndex(u => u.id === user.id);
                    this.$set(this.users, index,   user);
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }else if(this.editable == 'update'){
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                     this.fetch();
                }else if(this.editable == 'filter'){
                    this.arr = user;
                    this.$bvModal.hide("filter");
                    this.fetch();
                }else if(this.editable == 'education'){
                    this.arr2 = user;
                    this.$bvModal.hide("education");
                    this.fetch();
                }else{  
                    this.users.unshift(user);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                }
                this.editable = false;
            }
        }
    }, components : { Update , FilterLocation, FilterEducation }
}
</script>