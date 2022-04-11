<template>
    <div class="d-lg-flex">
        <div class="chat-leftsidebar me-lg-4">
            <div class="">
                <div class="py-4 border-bottom" style="margin-top: -20px;">
                    <div class="media">
                        <div class="align-self-center me-3">
                            <img class="rounded avatar-md" :src="currentUrl+'/images/avatars/'+user.avatar" alt="">
                        </div>
                        <div class="media-body">
                            <h5 class="font-size-15 mt-0 mb-1 mt-1">
                                {{user.firstname}} {{user.lastname}}
                            </h5>
                            <p class="text-muted font-size-11 fw-bold mb-0">{{user.spas_id}}</p>
                            <p class="text-muted mb-0"><span :class="'badge bg-'+user.status_id.color">{{user.status_id.name}} </span></p>
                        </div>
                        <b-dropdown menu-class="dropdown-menu-end" class="chat-noti-dropdown active" right variant="white">
                            <template v-slot:button-content>
                                <i class="bx bx-bell bx-tada"></i>
                            </template>
                            <b-dropdown-item @click="updateStatus(user.id,user.status_id)">Update Status</b-dropdown-item>
                            <b-dropdown-item>Update Level</b-dropdown-item>
                        </b-dropdown>
                    </div>
                </div>

                <div class="search-box chat-search-box py-4">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <i class="bx bx-search-alt search-icon"></i>
                    </div>
                </div>

                <div @click="selected = 1"  class="card border shadow-none"  style="margin-bottom: 4px;">
                    <router-link :to="{ path: '/scholar/'+id }" class="text-body">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ms-2 me-2">
                                    <div class="avatar-title rounded bg-transparent">
                                        <i class='text-warning bx bx-home h4 mt-1'></i>
                                    </div>
                                </div> 
                                <div class="overflow-hidden me-auto align-self-center">
                                    <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 1) ? 'text-primary' : ''">Home</h5> 
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>

                <div @click="selected = 2" class="card border shadow-none"  style="margin-bottom:4px;">
                    <router-link :to="{ name: 'profilee',  params: {data : user }}" class="text-body">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ms-2 me-2">
                                    <div class="avatar-title rounded bg-transparent">
                                        <i class='text-primary bx bx-user-circle h4 mt-1'></i>
                                    </div>
                                </div> 
                                <div class="overflow-hidden me-auto align-self-center">
                                    <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 2) ? 'text-primary' : ''">Profile Information</h5> 
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>

                <div @click="selected = 3" class="card border shadow-none"  style="margin-bottom: 4px;">
                    <router-link :to="{ name: 'financial'}" class="text-body">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ms-2 me-2">
                                    <div class="avatar-title rounded bg-transparent">
                                        <i class='text-danger bx bx-money h4 mt-1'></i>
                                    </div>
                                </div> 
                                <div class="overflow-hidden me-auto align-self-center">
                                    <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 3) ? 'text-primary' : ''">Financial Benefits</h5> 
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>

                <div @click="selected = 4" class="card border shadow-none"  style="margin-bottom: 4px;">
                    <router-link :to="{ name: 'enrollment' }" class="text-body">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ms-2 me-2">
                                    <div class="avatar-title rounded bg-transparent">
                                        <i class='text-success bx bxs-school h4 mt-1'></i>
                                    </div>
                                </div> 
                                <div class="overflow-hidden me-auto align-self-center">
                                    <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 4) ? 'text-primary' : ''">Enrollment Information</h5> 
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
                
                <div @click="selected = 5"  class="card border shadow-none"  style="margin-bottom: 4px;">
                    <router-link :to="{ name: 'trace' }" class="text-body">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ms-2 me-2">
                                    <div class="avatar-title rounded bg-transparent">
                                        <i class='text-info bx bx-user-pin h4 mt-1'></i>
                                    </div>
                                </div> 
                                <div class="overflow-hidden me-auto align-self-center">
                                    <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 5) ? 'text-primary' : ''">Employment History</h5> 
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>

                <div @click="selected = 6"  class="card border shadow-none"  style="margin-bottom: 4px;">
                    <router-link :to="{ name: 'prospectus' }" class="text-body">
                        <div class="p-1">
                            <div class="d-flex mt-1">
                                <div class="avatar-xs align-self-center ms-2 me-2">
                                    <div class="avatar-title rounded bg-transparent">
                                        <i class='text-secondary bx bx-notepad h4 mt-1'></i>
                                    </div>
                                </div> 
                                <div class="overflow-hidden me-auto align-self-center">
                                    <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 6) ? 'text-primary' : ''">Prospectus</h5> 
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>

        <div class="w-100 user-chat">
            <div class="card" :style="{ height: height + 'px' }">
                <div class="p-4">
                    <div class="row">
                        <router-view :dropdowns="dropdowns" :user="user"></router-view>
                    </div>
                </div>
            </div>
        </div>

        <Status ref="updateStatus" @status="message"/>
    </div>
</template>


<script>
    import Status from './Status.vue';
    export default {
        props: ['dropdowns'],
        data(){
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.$parent.$parent.height,
                user: {
                    status_id: {}
                },
                selects : [],
                selected: 1,
                id : this.$route.params.id
            }
        },

        created(){
            this.fetch();
        },

        methods : {
            fetch(){
                axios.get(this.currentUrl + '/request/scholar/'+this.$route.params.id)
                .then(response => {
                    this.user = response.data.data;
                })
                .catch(err => console.log(err));
            },

            updateStatus(id,status){
                this.$bvModal.show("updateStatus");
                this.$refs.updateStatus.set(id,status);
            },

            message(status){
                this.user.status_id = status;
                this.$bvModal.hide("updateStatus");
                Vue.$toast.success('<strong>Successfully Updated</strong>', {
                    position: 'bottom-right'
                });
            }
        }, components : { Status }
    }
</script>
