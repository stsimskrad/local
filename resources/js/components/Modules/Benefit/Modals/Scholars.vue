<template>
    <b-modal id="scholars" title="Scholars" size="lg" hide-footer centered>
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive mt-1" data-simplebar :style="{ height: (height-270) + 'px' }">
                        <table class="table table-nowrap align-middle table-hover mb-0">
                            <tbody>
                                <tr class="font-size-11" v-for="list in lists" v-bind:key="list.id">
                                    <td>
                                        <i v-if="list.is_completed"
                                            class='bx bxs-check-circle h5 mt-1 text-success'></i>
                                        <i v-else class='bx bxs-x-circle h5 mt-1 text-danger'></i>
                                    </td>
                                    <td>{{ list.scholar.profile.firstname }} {{ list.scholar.profile.lastname }}</td>
                                    <td>{{list.count}} of 5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                lists : [],
                height: ''
            }
        },

        methods: {
            set(data,height){
                this.lists = data;
                this.height = height;
            }
        }
    }

</script>
