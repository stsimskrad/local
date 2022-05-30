<template>
    <div>
        <table class="table table-centered table-nowrap">
            <thead class="thead-light align-middle">
                    <tr class="font-size-11">
                    <th style="width: 1%;"></th>
                    <th>Spas ID </th>
                    <th class="text-center">Name </th>
                    <th class="text-center">Region From</th>
                    <th class="text-center">Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <tr v-for="user in users" v-bind:key="user.id">
                    <td></td>
                    <td>
                        {{user.spas_id}}
                    </td>
                    <td class="text-center">
                        <h5 class="font-size-13 mb-0 text-dark">{{user.name}}</h5>
                    </td>
                        <td class="text-center">
                        <span class="fw-bold">{{ user.endorsed_region }}</span>  <span class="text-muted">({{ user.endorsed_name}})</span>
                    </td>
                    <td class="text-center">
                        {{ user.created_at }}
                    </td>
                    <td class="text-end">
                        <button type="button" @click="viewEndorsement(user)" class="bg-light btn btn-light"><i class='bx text-warning bx-show'></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Endorse ref="endorsement"/>
    </div>
</template>
<script>
import Endorse from "../Modals/Endorsement.vue";
export default {
    components : { Endorse },
    data(){
        return {
            currentUrl: window.location.origin,
            users: []
        }
    },

    created(){
        this.fetchEndorsements();
    },

    methods : {
        fetchEndorsements() {
            axios.get(this.currentUrl + '/request/qualifiers/endorsement')
            .then(response => {
                this.users = response.data.data;
            })
            .catch(err => console.log(err));
        },

        viewEndorsement(data){
            this.$nextTick(function () {
                this.$refs.endorsement.set(data);
            });
            this.$bvModal.show("endorsement");
        },

    }
}
</script>