<template>
  <pdf :src="currentUrl+'/storage/'+attachment">
    <template slot="loading">
      loading content here...
    </template>
  </pdf>
</template>

<script>
import pdf from 'pdfvuer'

export default {
  props: ['attachment'],
  components: {
    pdf
  },
  data(){
    return{
      currentUrl: window.location.origin,
    }
  }
}
</script>