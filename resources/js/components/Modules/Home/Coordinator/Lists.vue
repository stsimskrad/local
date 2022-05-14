<template>
    <div>
        <ul class="list-inline user-chat-nav text-start ms-4 mt-1 dropdown">
            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <button type="button"
                    class="btn btn-sm w-sm ms-n4 me-n3 ml-1 btn-secondary">Update</button>
            </li>
            <!-- <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <i class="bx bxs-check-circle text-success h4"
                    style="margin-left: -22px; position: absolute;"></i>
                <span class="text-muted font-size-11">Completed : 1</span>
            </li>
            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <i class="bx bxs-info-circle text-warning h4"
                    style="margin-left: -22px; position: absolute;"></i>
                <span class="text-muted font-size-11">Incomplete : 1</span>
            </li> -->
            <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="subprogram"
                        id="gridCheck" />
                    <label class="form-check-label font-size-11" for="gridCheck">Show
                        Sub-Programs</label>
                </div>
            </li>
             <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 50px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="graphical"
                        id="gridCheck" />
                    <label class="form-check-label font-size-11" for="gridCheck">Show
                        Graphical View</label>
                </div>
            </li>
        </ul>
        <b-tabs pills nav-class="bg-light rounded" content-class="mt-3" small>
            <b-tab active title="Provinces">
                <b-card-text>
                    <div class="table-responsive">
                        <table class="table table-centered table-bordered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr class="font-size-10">
                                    <th style="width: 20%;">Province</th>
                                    <th style="width: 13%;" class="text-center"
                                        v-for="program in programs_list" v-bind:key="program.id">
                                        {{ program.name }}</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-centered table-bordered table-nowrap">
                            <tbody class="font-size-11">
                                <tr v-for="(province,index) in provinces" v-bind:key="index">
                                    <td style="width: 20%;">
                                        {{ province.province.name }}</td>
                                    <td style="width: 13%;" v-if="index < counts" class="text-center fw-bold" v-for="(count,index) in province.count" v-bind:key="index">
                                        {{ count }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <table class="table table-centered table-bordered table-nowrap mb-0">
                        <tfoot class="thead-light">
                            <tr class="font-size-12">
                                <th style="width: 80%;" colspan="3"></th>
                                <th class="text-center text-primary" style="width: 10%;">{{ units }}</th>
                                <th class="text-center text-primary" style="width: 10%;">{{ total }}</th>
                            </tr>
                        </tfoot>
                    </table> -->
                    </div>
                </b-card-text>
            </b-tab>
            <b-tab title="Programs">
                <b-card-text>
                    <div class="table-responsive">
                        <table class="table table-centered table-bordered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr class="font-size-10">
                                    <th style="width: 40%;">Name</th>
                                    <th style="width: 20%;" class="text-center">Undergraduate</th>
                                    <th style="width: 20%;" class="text-center">JLSS</th>
                                    <th style="width: 20%;" class="text-center">Total</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-centered table-bordered table-nowrap">
                            <tbody class="font-size-11">
                                <tr v-for="(program,index) in undergraduates" v-bind:key="index">
                                    <td style="width: 40%;" class="fw-bold">
                                        {{ program.name }}
                                    </td>
                                    <td style="width: 20%;" class="text-center">
                                        {{ (program.name == 'RA 10612') ? '-' : program.scholar_count }}
                                    </td>
                                    <td style="width: 20%;" class="text-center">{{ jlss[index].scholar_count }}</td>
                                    <td style="width: 20%;" class="fw-bold text-center">{{ program.scholar_count + jlss[index].scholar_count}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </b-card-text>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            type_programs: [],
            provinces: [],
            programs: { undergrad: []},
            subprogram: false,
            graphical: false
        }
    },

    created() {
        this.fetch();
    },

    computed: {
        undergraduates : function(){
            if(this.subprogram == false){
                return this.programs.undergrad.filter(x => x.is_sub === 0);
            }else{
                return this.programs.undergrad;
            }
        },
        jlss : function(){
            if(this.subprogram == false){
                return this.programs.jlss.filter(x => x.is_sub === 0);
            }else{
                return this.programs.jlss;
            }
        },
        programs_list : function(){
            if(this.subprogram == false){
                return this.type_programs.filter(x => x.is_sub === 0);
            }else{
                return this.type_programs;
            }
        },
        counts : function(){
            return this.programs_list.length;
        }
    },

    methods : {
        fetch() {
            axios.get(this.currentUrl + '/public/lists')
            .then(response => {
                this.provinces = response.data.provinces.provinces;
                this.type_programs = response.data.provinces.programs;
                this.programs = response.data.programs;
            })
            .catch(err => console.log(err));
        },
    }
}
</script>