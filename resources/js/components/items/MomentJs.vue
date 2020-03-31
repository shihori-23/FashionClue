<template>
  <span class="moment font-weight-light caption">{{postTime}}</span>
</template>
<script>
import moment from "moment";

export default {
  props: {
    time: String
  },
  computed: {
    postTime: function() {
      return moment(this.time, "YYYY/MM/DD HH:mm:S")
        .add(9, "hours")
        .fromNow();
      // return moment(this.time)
      //     .add(9, "hours")
      //     .format("YYYY/MM/DD(ddd) hh:mm");
    }
  }
};
</script>

<style scoped>
.moment {
  text-align: right;
  /* margin-right: 20px; */
  margin-bottom: 0;
  vertical-align: middle;
  color: #a0a0a0;
}
</style>