<template>
    <div class="row g-3">
        <div class="col-md-4" v-if="latest == 'empty'">
            <div class="card">
                <div class="card-body mb-n4" :style="{ height: (height + 25) + 'px' }">
                    <a href="#" tabindex="-1" class="btn btn-secondary disabled placeholder col-12 mb-4"></a>
                    <h5 class="card-title placeholder-glow"><span class="placeholder col-6"></span></h5>
                    <p class="card-text placeholder-glow"><span class="placeholder col-7"></span>
                    <span class="placeholder col-4"></span><span class="placeholder col-4"></span>
                    <span class="placeholder col-6"></span><span class="placeholder col-8"></span></p>
                </div>
            </div>
        </div>
        <div v-else class="col-md-4">
            <div class="card">
                <div class="card-body mb-n4">
                    <div class="col-md-12 mb-3">
                        <div class="search-box input-group bg-light rounded">
                            <input type="text" placeholder="Search" class="form-control bg-transparent border-0">
                            <i class="bx bx-search-alt search-icon"></i>
                            <button @click="home" type="button" class="btn btn-danger">
                                <i class='bx bxs-home'></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-12" style="cursor: pointer;">
                        <div class="card shadow-none border">
                            <div class="card-body p-3">
                                <div class="mt-n2 mb-n2">
                                    <div class="avatar-xs me-3 mb-2">
                                        <div class="avatar-title bg-transparent rounded">
                                            <i class="bx bxs-folder font-size-24 text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="overflow-hidden me-auto">
                                            <h5 class="font-size-14 text-truncate mb-0">
                                                <a class="text-body">{{ latest.group.academic_year}}</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0">
                                                {{ latest.group.semester.name }}
                                            </p>
                                        </div>
                                        <div class="align-self-end ms-2">
                                            <p class="fw-bold font-size-11 text-muted mb-0">
                                                {{ latest.group.lists.length}}
                                                Enrolled Scholar<span v-if="latest.group.lists.length > 1">s</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-n4">
                    <div class="">
                        <div class="card border shadow-none mb-2">
                            <a href="javascript: void(0);" class="text-body">
                                <div class="p-2">
                                    <div class="d-flex">
                                        <div class="avatar-xs align-self-center me-2">
                                            <div class="avatar-title rounded bg-transparent text-success font-size-20">
                                                <i class="bx bxs-calendar-week"></i>
                                            </div>
                                        </div>
                                        <div class="overflow-hidden me-auto">
                                            <h5 class="font-size-13 text-truncate mb-0">{{ latest.month.name.month }}</h5>
                                            <p class="text-muted text-truncate mb-0">
                                                {{ latest.month.pending.length }} Pending Scholar
                                                <span v-if="latest.month.pending.length > 1">s</span>
                                            </p>
                                        </div>
                                        <div class="ms-2 mt-1 mb-n2">
                                            <i @click="newRelease()" class='bx bxs-plus-circle h2'></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="table-responsive mb-4" data-simplebar :style="{ height: (height-323) + 'px' }">
                            <table class="table table-nowrap align-mid table-hover mt-2 mb-0">
                                <tbody>
                                    <tr v-for="list in latest.month.name.releases" v-bind:key="list.id" @click="set()" style="cursor: pointer;">
                                        <td>
                                            <h5 class="text-truncate font-size-13 mb-0">
                                                <a href="javascript: void(0);" class="text-dark">
                                                    <span class="text-primary fw-bold">Release
                                                        no.{{ list.number }}</span>
                                                </a>
                                            </h5>
                                            <p class="text-muted mb-0 font-size-12">{{ list.created_at}}</p>
                                        </td>
                                        <td class="text-end">
                                            <p class="mb-0 font-size-12">₱{{ formatMoney(list.total) }}</p>
                                            <p class="text-muted mb-0 font-size-12">{{ list.scholars }} Scholar<span
                                                    v-if="list.scholars > 1">s</span></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top mt-n4 mb-n2">
                    <div class="row mt-n2 mb-n2">
                        <div class="col-sm-6">
                            <div>
                                <p class="text-muted mb-0">Total Amount</p>
                                <h6>₱{{ formatMoney(latest.total) }}</h6>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end mt-4 mt-sm-0">
                                <p class="text-muted mb-0">Month of {{ m}}</p>
                                <h6> ₱{{ formatMoney(latest.monthly) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <Main :height="height" ref="main" />
            </div>
        </div>
        <Group @status="message" :dropdowns="dropdowns"/>
    </div>
</template>
<script>
    import Group from './Modals/Group.vue';
    import Main from './Main.vue';
    export default {
        components: { Main, Group },
        props: ['height', 'dropdowns'],
        data() {
            return {
                currentUrl: window.location.origin,
                latest: {
                    semester: '',
                    lists: [],
                    group: {
                        semester: '',
                        lists: ''
                    },
                    month: {
                        name: '',
                        pending: ''
                    },
                },
                m: new Date().toLocaleString('en-us', {
                    month: 'long'
                }),
            }
        },

        created() {
            this.fetchLatest();
        },

        methods: {
            fetchLatest() {
                axios.get(this.currentUrl + '/request/benefit/group/latest')
                .then(response => {
                    this.latest = response.data;
                    (this.latest == 'empty') ? this.$bvModal.show("warning") : '';
                })
                .catch(err => console.log(err));
            },

            newRelease() {
                this.type = 'releasing';
                this.$refs.main.type(this.type, this.latest);
            },

            home() {
                this.type = 'index';
                this.$refs.main.type(this.type, this.latest);
            },

            message() {
                this.fetchLatest();
                this.$refs.main.back();
            },

            formatMoney(value) {
                let val = (value / 1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            set(){
                this.$refs.main.set(this.latest.group);
            }
        }
    }

</script>
