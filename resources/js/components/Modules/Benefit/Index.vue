<template>
    <div class="row">
        <div class="col-md-12 mb-n2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search-box input-group bg-light rounded">
                                <input type="text" @keyup="fetch()" v-model="keyword" placeholder="Search Scholar" class="form-control bg-transparent border-0">
                                <i class="bx bx-search-alt search-icon"></i>
                                <button @click="filter" type="button" class="btn"
                                    :class="[(advanced) ? 'btn-danger' : 'btn-info']">
                                    Advanced Search
                                </button>
                            </div>

                            <div v-if="advanced == true">
                                <hr style="height: .5px; opacity: .1;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <multiselect @input="onChange(status,'status')" v-model="status"
                                            :options="statuses" label="name" track-by="id" placeholder="Select Status">
                                        </multiselect>
                                    </div>

                                    <div class="col-md-2">
                                        <multiselect @input="onChange(year,'year')" v-model="year" :options="years"
                                            placeholder="Select Awarded year">
                                        </multiselect>
                                    </div>

                                    <div class="col-md-2">
                                        <multiselect @input="onChange(year,'year')" v-model="level" :options="levels"
                                            label="name" track-by="id" placeholder="Select Level">
                                        </multiselect>
                                    </div>
                                    <div class="col-md-5">
                                        <multiselect @input="onChange(school,'school')" @search-change="asyncSchool"
                                            v-model="school" :options="schools" :searchable="true" label="name"
                                            track-by="id" placeholder="Select School">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card" v-if="viewdiv == false">
                <div class="card-body" :style="{ height: (hayt-90) + 'px' }">
                    <div v-if="users.length > 0" class="row mb-3">
                        <div class="col-md-12">
                            <div class="float-start">
                                <span class="fw-bold font-size-13">{{ users.length }}</span> <span class="text-muted">Scholar<span v-if="users.length > 1">s</span> found</span>
                            </div>
                            <div class="float-end">
                                <button :disabled="(selected.length > 0) ? false : true" @click="ups('create')" type="button" class="btn btn-light w-lg btn-sm me-1">Add Financial Benefit</button>
                                <button :disabled="(selected.length > 0) ? false : true" @click="ups('updateStatus')" type="button" class="btn btn-light w-lg btn-sm">Update Status</button>
                            </div>
                        </div>
                    </div>
                   
                        <table class="table table-centered table-nowrap mb-0"  v-if="users.length > 0">
                            <thead class="thead-light">
                                <tr class="font-size-11">
                                    <th style="width: 5%;">                                
                                        <b-form-checkbox :value="'all'" @input="checkAll()" v-model="isCheckAll" unchecked-value="not_accepted" checked plain style="font-size: 20px; margin-top: -5px;"> </b-form-checkbox>
                                    </th>
                                    <th style="width: 40%;">Name</th>
                                    <th style="width: 30%;" class="text-center">School</th>
                                    <th style="width: 15%;" class="text-center">Awarded Year</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                        </table>
                         <div v-if="users.length > 0" class="table-responsive" :style="{ 'max-height': (height-300) + 'px' }" data-simplebar>
                        <table class="table table-centered table-nowrap mb-0">
                            <tbody>
                                <tr v-for="user in users" v-bind:key="user.id">
                                    <td style="width: 5%;">
                                        <b-form-checkbox :id="'customCheck_'+user.id" v-on:change='updateCheckall()'
                                            :value="user.id" v-model="selected" unchecked-value="not_accepted" checked
                                            plain style="font-size: 15px;">
                                        </b-form-checkbox>
                                    </td>
                                    <td @click="viewScholar(user)" style="width: 40%; cursor:pointer;" class="text-left text-body fw-bold">{{user.lastname}}, {{user.firstname}} {{user.middlename}}</td>
                                    <td style="width: 30%;" class="text-center font-size-11">{{user.school}}</td>   
                                    <td style="width: 15%;" class="text-center text-primary fw-bold font-size-11">{{user.awarded_year}}</td>   
                                    <td style="width: 10%;" class="text-end">
                                        <span v-if="user.status.type == 'ongoing'" :class="'badge bg-'+user.status.color">{{user.status.name}}</span>
                                        <span v-else :class="'badge badge-pill badge-soft-'+user.status.color">{{user.status.name}}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="col-md-2 mx-auto mt-5">
                        <img class="img-fluid" src="/images/svg/employment.svg">
                        <div class="justify-content-center">
                            <div class="col-xl-12">
                                <p class="text-muted text-center font-size-12 mt-4">No Scholar was found. Search again
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Profile :height="height" v-else ref="profile"/>
        </div>
        <Financial ref="create" :dropdowns="dropdowns" @status="message"/>
    </div>
</template>
<script>
    import Profile from './Profile.vue';
    import Financial from './Modals/Create.vue';
    import Multiselect from 'vue-multiselect';
    export default {
        components: { Multiselect , Financial, Profile },
        props: ['height', 'dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                keyword: '',
                year: '',
                level: '',
                status: '',
                school: '',
                users: [],
                schools: [],
                advanced: false,
                isCheckAll: false,
                selected: [],
                viewdiv: false
            }
        },

        computed: {
            years: function () {
                const year = new Date().getFullYear();
                const arr = Array.from({
                    length: year - 2014
                }, (value, index) => 2015 + index);
                return arr.reverse();
            },
            levels: function () {
                return this.dropdowns.filter(x => x.classification === 'Level');
            },
            statuses: function () {
                return this.dropdowns.filter(x => x.classification === 'Status');
            },
            hayt: function () {
                if (this.advanced) {
                    return this.height - 72;
                }else{
                    return this.height;
                }
            }
        },

        methods: {
            fetch() {
                if(this.keyword.length > 4 && this.advanced == false){
                    this.fetchUsers();
                }else if(this.advanced == true){
                    this.fetchUsers();
                }else{}
            },

            fetchUsers(){
                this.viewdiv = false;
                let key, t, s, l, y;
                (this.status != '' && this.status != null) ? t = this.status.id: t = '-';
                (this.school != '' && this.school != null) ? s = this.school.id: s = '-';
                (this.level != '' && this.level != null) ? l = (this.level == 'all') ? '-' : this.level.id: l = '-';
                (this.year != '' && this.year != null) ? y = this.year: y = '-';
                (this.keyword != '' && this.keyword != null) ? key = this.keyword: key = '-';

                axios.get(this.currentUrl + '/request/scholar/filter/' + t + '/' + s + '/' + y + '/' + l + '/' + key)
                .then(response => {
                    this.users = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChange() {
                this.selected = [];
                this.isCheckAll = false;
                this.value = '';
                // this.type = '';
                this.fetch();
            },

            asyncSchool(value) {
                if (value.length > 5) {
                    axios.post(this.currentUrl + '/lists/search/schools', {
                        word: value,
                    })
                    .then(response => {
                        this.schools = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            filter() {
                if (this.advanced) {
                    this.advanced = false;
                    this.school = '';
                    this.level = '';
                    this.year = '';
                    this.status = '';
                } else {
                    this.advanced = true;
                    this.keyword = '';
                }
                this.users = [];
                this.selected = [];
                this.viewdiv = false;
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
                if (this.selected.length == this.users.length) {
                    this.isCheckAll = true;
                } else {
                    this.isCheckAll = false;
                }
            },

            viewScholar (user){
                this.advanced = false;
                (this.viewdiv == true) ? this.viewdiv = false : this.viewdiv = true;
                 this.$nextTick(function () {
                    this.$refs.profile.set(user);
                });
            },

            ups(type){
                this.$bvModal.show(type);
                this.$refs[type].many(this.selected);
            },

            message(status){
                this.users = [];
                this.selected = [];
            },

        }
    }

</script>
