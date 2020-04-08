<template>
  <span class="genderSpan">{{ gender[genderRole - 1] }}</span>
</template>

<script>
export default {
  props: {
    genderRole: Number
  },
  data() {
    return {
      gender: ["レディース", "メンズ"]
    };
  },
  methods: {}
};
</script>
<style scoped>
</style>
