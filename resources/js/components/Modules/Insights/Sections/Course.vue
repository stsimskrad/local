<template>
<div>
    <div class="card-body border-bottom">
        <div class="page-title-left">
            <h6 class="fw-bold mb-n1">Most Courses</h6>
        </div>
    </div>
    <div class="card-body" style="height: 330px;">
        <table class="table table-centered table-nowrap align-middle" style="table-layout: fixed;">
            <colgroup>
                <col width="10%" />
                <col width="75%" />
                <col width="15%" />
            </colgroup>
            <thead class="thead-light">
                <tr class="font-size-10">
                    <th>#</th>
                    <th>Name</th>
                    <th class="text-center">Count</th>
                </tr>
            </thead>
            <tbody class="font-size-11">
                <tr v-for="(course,index) in courses" v-bind:key="index">
                    <td>{{ index+1 }}</td>
                    <td class="text-truncate">{{ course.name }}</td>
                    <td class="text-center fw-bold">{{course.scholars_count}} <span class="text-muted font-size-11">({{percentage(course.scholars_count)}})</span></td>
                </tr>
            </tbody>
        </table>
        <div class="text-center my-3"><a href="javascript:void(0);" class="text-success">See All .. </a>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: ['courses','total'],
    methods : {
        percentage(data){
            return Math.floor((data/this.total)*100)+'%';
        }
    }
}
</script>