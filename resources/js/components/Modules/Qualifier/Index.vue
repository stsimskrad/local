<template>
    <div>
        <div class="row mb-4">
            <div class="col-xl-6">
                <router-link :to="{ name: 'qualifier/sync' }"> 
                    <button type="button" class="btn btn-sm w-sm mb-n3 btn-outline-light">Sync</button>
                </router-link>
                <router-link :to="{ name: 'qualifier/import' }">
                    <button type="button" class="btn btn-sm w-sm mb-n3 btn-outline-light">Import</button>
                </router-link>
                <button type="button" class="btn btn-sm w-sm mb-n3 btn-outline-light">Mail</button>
                 <!-- <router-link :to="{ name: 'qualifier/sync' }"> 
                    <button type="button" class="btn btn-danger waves-effect waves-light mr-2"><i class='bx bx-sync'></i></button>
                </router-link>
                <router-link :to="{ name: 'qualifier/import' }">
                    <button type="button" class="btn btn-info waves-effect waves-light mr-2"><i class='bx bx-import'></i></button>
                </router-link>
                <button type="button" class="btn btn-light"><span class="d-none d-sm-inline-block"> <i class='bx bx-mail-send'></i></span></button>                                  -->
                       
            </div>
            <div class="col-xl-6">
                <ul class="list-inline user-chat-nav text-end mb-0 dropdown">
                    <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;" v-if="selected.length > 0">     
                        <i class='bx bx-check-square text-success h4' style="margin-left: -22px; position: absolute;"></i> <span class="text-muted font-size-11">{{selected.length}} Qualifiers selected</span>
                    </li>
                    <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">     
                        <i class='bx bxs-error-circle text-warning h4' style="margin-left: -22px; position: absolute;"></i> <span class="text-muted font-size-11">With Remarks</span>
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
                     <select v-model="type" @change="fetch()" class="form-select" style="width: 100px; font-weight: 500;">
                        <option value="Qualifiers" selected="">Qualifiers</option>
                        <option value="Endorsed">Endorsed</option>
                        <option value="Qualified">Qualified</option>
                    </select>
                     <select v-model="is_undergrad" @change="fetch()" class="form-select" :class="(program == null) ? 'text-muted' : ''" style="width: 100px; font-weight: 500;">
                        <option value="all" selected="">All</option>
                        <option value="1">Undergraduate</option>
                        <option value="0">JLSS</option>
                    </select>
                    <select  v-model="program" @change="fetch()" placeholder="Choose Program" class="form-select" :class="(program == null) ? 'text-muted' : ''" style="width: 100px;">
                        <option :value="null" selected>All Program</option>
                        <option :value="program" v-for="program in programs" v-bind:key="program.id">{{ program.name }}</option>
                    </select>
                    <input type="text" class="form-control" style="width: 100px;" placeholder="Enter Year" v-model="year"  @keyup="fetch()"/>
                </div>
            </div>
            
        </div>
        
        <div class="table-responsive">
            <table class="table table-centered table-nowrap">
                <thead class="thead-light align-middle">
                        <tr class="font-size-11">
                        <th>
                           <b-form-checkbox :value="'all'" @input="checkAll()" v-model="isCheckAll" unchecked-value="not_accepted" checked plain style="font-size: 16px;"> </b-form-checkbox>
                        </th>
                        <th style="width: 1%;"></th>
                        <th>Name </th>
                        <th class="text-center">Program</th>
                        <th class="text-center">Contact</th>
                        <th v-if="type != 'Endorsed'"></th>
                        <th v-else>Status</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <tr v-for="user in users" v-bind:key="user.id" :class="[(user.info.requirements.count > 0) ? 'table-warning' : '']">
                        <td style="width: 1%;">
                            <b-form-checkbox :id="'customCheck_'+user.id" v-on:change='updateCheckall()'
                                :value="user.id" v-model="selected" unchecked-value="not_accepted" checked plain 
                                style="font-size: 16px;">
                            </b-form-checkbox>
                        </td>
                        <td>
                            <div class="avatar-xs" v-if="user.avatar == 'n/a'">
                                <span class="avatar-title rounded-circle">{{user.lastname.charAt(0)}}</span>
                            </div>
                            <div v-else>
                                <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+user.avatar" alt="">
                            </div>
                        </td>
                        <td style="cursor: pointer;" @click="profile(user)">
                            <h5 class="font-size-13 mb-0 text-dark">{{user.lastname}}, {{user.firstname}} {{user.middlename}}</h5>
                            <!-- <p class="font-size-11 text-muted mb-0">{{user.barangay}}, {{user.municipality}}, {{user.province}}</p> -->
                            <p class="font-size-11 text-muted mb-0">SPAS ID : <span class="fw-bold">{{user.spas_id}}</span></p>
                        </td>
                        <td class="text-center">
                            <h5 class="font-size-13 mb-0 text-dark">{{user.program_id.name}}</h5>
                            <p class="font-size-11 text-muted mb-0">{{(user.is_undergrad) ? 'Undergraduate' : 'JLSS'}}</p>
                        </td>
                        <td class="text-center">
                            <h5 class="font-size-11 mb-0 text-dark">{{user.email}} / {{user.mobile}}</h5>
                            <p class="font-size-11 text-muted mb-0">{{user.barangay}}, {{user.municipality}}, {{user.province}}</p>
                        </td>
                        <td class="text-end" v-if="user.is_referral == 0 && user.is_qualified == NULL">
                            <button type="button" @click="warning(user)" class="bg-light btn btn-light" v-if="user.info.requirements.count > 0"><i class='bx text-warning bxs-info-circle'></i></button>
                            <button type="button" @click="addScholar(user)" class="bg-light btn btn-light" v-if="user.info.requirements.count < 1"><i class='bx text-info bx-plus-medical'></i></button>
                            <button type="button" @click="refer(user)" class="bg-light btn btn-light" style="margin-end: -10px;"><i class='bx bx-transfer-alt'></i></button>
                            <!-- <button type="button" @click="scholar(user)" class="btn btn-sm btn-danger w-sm waves-effect waves-light">Add Scholar</button> -->
                        </td>
                        <td v-else>
                            n/a
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Warning @status="message" ref="warning"/>
        <Profile @status="message" ref="profile"/>
        <Add :regions="regions" :dropdowns="dropdowns" @status="message" ref="add"/>
        <Referral @status="message" ref="referral"/>
    </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import Warning from './Modals/Warning.vue';
import Profile from './Modals/Profile.vue';
import Add from './Modals/Add.vue';
import Referral from './Modals/Referral.vue';
export default {
    props: ['dropdowns','regions','programs'],
    data(){
        return {
            currentUrl: window.location.origin,
            counts: this.$parent.$parent.$parent.$parent.counts,
            errors: [],
            pagination: {},
            keyword: '',
            users : [],
            selected: [],
            program: null,
            year: null,
            show: false,
            isCheckAll: false,
            is_undergrad : 'all',
            type: 'Qualifiers',
            options: ['Qualifiers','Endoresed','Qaulified']
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
            page_url = page_url || this.currentUrl + '/request/qualifiers';
            axios.get(page_url,{ 
                params: { 
                    count : this.counts, 
                    program : (this.program ==  null) ? null : this.program.id, 
                    year: this.year, 
                    keyword: this.keyword,
                    type: this.type,
                    is_undergrad: this.is_undergrad
                }
            })
            .then(response => {
                this.users = response.data.data;
                if (this.isCheckAll == 'all') { // Check all
                    for (var key in this.users) {
                        this.selected.push(this.users[key].id);
                    }
                }
                this.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        filter(data,type){
            switch(type){
                case 'category':
                    this.category = data;
                break;
            }

            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            this.fetch(this.currentUrl + '/request/qualifiers/'+this.counts+'/'+this.category+'/'+this.year+'/'+key);
        },

        edit(user){
            this.editable = true;
            this.$refs.create.edit(user,true);
        },

        yr(){
            (this.show == false) ? this.show = true : this.show = false;
        },

        profile(user){
            this.$refs.profile.set(user);
            this.$bvModal.show("profile");
        },

        warning(user){
            this.$refs.warning.set(user);
            this.$bvModal.show("warning");
        },

        refer(user){
            this.editable = 'endorsement';
            this.$refs.referral.set(user);
            this.$bvModal.show("referral");
        },

        addScholar(user){
            this.editable = 'qualifier';
            this.$refs.add.set(user);
            this.$bvModal.show("add");
        },

        message(user){
            if(user){
                if(this.editable == true){
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }else if(this.editable == 'qualifier'){
                    this.users.splice(this.users.indexOf(user), 1);
                    Vue.$toast.success('<strong>Qualifier was added as Scholar</strong>', {
                        position: 'bottom-right'
                    });
                }else if(this.editable == 'endorsement'){
                    this.users.splice(this.users.indexOf(user), 1);
                    Vue.$toast.success('<strong>Successfully Endorsed</strong>', {
                        position: 'bottom-right'
                    });
                }else{
                    // console.log(user);
                    this.users.unshift(user);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                }
                this.editable = false;
            }
        },

        checkAll: function () {
            // this.isCheckAll = !this.isCheckAll;
            if (this.isCheckAll == 'all') { // Check all
                for (var key in this.users) {
                    this.selected.push(this.users[key].id);
                }
            } else {
                this.selected = [];
            }
        },

        updateCheckall: function () {
            // if (this.selected.length == this.users.length) {
            //     this.isCheckAll = true;
            // } else {
            //     this.isCheckAll = false;
            // }
        },

    }, components :{ Warning, Profile, Add, Referral, Multiselect }
}
</script>