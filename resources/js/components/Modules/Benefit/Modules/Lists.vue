<template>
    <div>
        <div class="card-body border-bottom">
            <div class="page-title-left mt-n2 ms-n3 mb-n3">
                <ol class="breadcrumb m-0 font-size-15">
                    <li>
                        <div class="avatar-xs me-3 mb-n2 mt-n1">
                            <div class="avatar-title bg-transparent rounded"><i
                                    class="bx bxs-folder-open font-size-24 text-warning"></i></div>
                        </div>
                    </li>
                    <li class="breadcrumb-item fw-bold ms-n2">{{ group.academic_year }}</li>
                    <li class="breadcrumb-item active"><span>{{group.semester.name }}</span></li>
                </ol>
            </div>
            <div class="float-end mt-n2">
                <button @click="back" type="button" class="mt-n4 btn btn-sm btn-label btn-secondary">
                <i class="bx bxs-chevrons-left label-icon"></i> Back </button>
            </div>
        </div>
        <div class="card-body border-bottom">
            <div class="row mb-n3">
                <div class="col-md-9">
                    <ul class="list-inline user-chat-nav text-start ms-4 mt-1 dropdown">
                        <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                            <button  @click="show(selected.lists)" type="button" class="btn btn-sm w-sm ms-n4 me-n3 ml-1 btn-secondary">Scholars ({{selected.lists.length}})</button>
                        </li>
                        <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                            <i class="bx bxs-check-circle text-success h4" style="margin-left: -22px; position: absolute;"></i> 
                            <span class="text-muted font-size-11">Completed : {{selected.completed}}</span>
                        </li>
                        <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                            <i class="bx bxs-info-circle text-warning h4" style="margin-left: -22px; position: absolute;"></i> 
                            <span class="text-muted font-size-11">Incomplete : {{(selected.lists.length-selected.completed)}}</span>
                        </li>
                        <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                            <i class="bx bxs-error-circle text-danger h4" style="margin-left: -22px; position: absolute;"></i> 
                            <span class="text-muted font-size-11">On hold : {{selected.hold}}</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm mb-2">
                        <label class="input-group-text" style="width: 110px;">Month Count : {{selected.months.length}}</label>
                        <select @change="select" v-model="month" class="form-select form-select-sm">
                            <option :value="month" v-for="month in selected.months">{{ month.month }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" :style="{ height: (height-134) + 'px' }">
            <div class="row">
                <div class="col-md-12 mt-n1">
                    
                    <b-tabs pills nav-class="bg-light rounded" content-class="mt-3" small>
                        <b-tab :active="index == 0" v-for="(l,index) in list" :title="'Released no.'+l.number"
                            v-bind:key="l.id">
                            <b-card-text>
                                <div class="table-responsive mt-n2 mb-n3">
                                    <table class="table table-centered table-bordered table-nowrap">
                                        <thead class="thead-light align-middle">
                                            <tr class="font-size-11">
                                                <th style="width: 50%">Name</th>
                                                <th style="width: 30%" class="text-center">Total</th>
                                                <th style="width: 20%"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table-responsive mt-n1" data-simplebar
                                    :style="{ height: (height-250) + 'px' }">
                                    <table class="table table-centered table-bordered table-nowrap">
                                        <tbody class="align-middle">
                                            <tr v-for="user in l.scholars" v-bind:key="user.id">
                                                <td style="cursor: pointer; width: 50%">
                                                    <h5 class="font-size-11  mb-0">{{user.scholar.profile.lastname}},
                                                        {{user.scholar.profile.firstname}}
                                                        {{user.scholar.profile.middlename}}</h5>
                                                </td>
                                                <td style="width: 30%" class="text-center text-success fw-bold font-size-11">
                                                    ₱ {{ formatMoney(user.total) }}
                                                </td>
                                                <td style="width: 30%" class="text-center text-success fw-bold font-size-11">
                                                    <button @click="view(user.total,user.lists)" type="button" class="btn btn-primary btn-sm btn-rounded">
                                                        View </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </b-card-text>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
        <Scholars ref="scholars" />
        <Lists ref="lists" />
    </div>
</template>
<script>
    import Release from "../Modals/Release.vue";
    import Scholars from "../Modals/Scholars.vue";
    import Lists from "../Modals/Lists.vue";
    export default {
        components: { Release, Scholars, Lists },
        props: ['height'],
        data() {
            return {
                currentUrl: window.location.origin,
                group: {
                    semester: {}
                },
                selected: { lists: [], months: []},
                list: '',
                month: ''
            }
        },

        methods: {

            fetch(id) {
                axios.get(this.currentUrl + '/request/benefit/view/' + id)
                .then(response => {
                    this.selected = response.data.data;
                    this.month = this.selected.months[0];
                    this.select();
                })
                .catch(err => console.log(err));
            },

            set(data) {
                console.log(data);
                this.group = data;
                this.fetch(data.id);
            },

            formatMoney(value) {
                let val = (value / 1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            back() {
                this.$emit('status', true);
            },

            select() {
                this.list = this.month.releases;
            },

            view(total,data){
                this.$refs.lists.set(total,data,this.height);
                this.$bvModal.show("lists");
            },

            show(data){
                this.$refs.scholars.set(data,this.height);
                this.$bvModal.show("scholars");
            }
        }
    }

</script>
