<template>
  <app-layout>
    <template slot="header">
      <h1>Liste des formations</h1>
    </template>
    <div class="py-6" v-for="course in this.courseList" v-bind:key="course.id">
      <div class="mx-8 bg-white rounded shadow p-3">
        <div class="flex justify-between items-center">
          <div class="text-3xl">{{ course.title }}</div>
          <div class="text-sm text-gray-500">25 épisodes</div>
        </div>

        <div class="text-sm text-gray-500">{{ course.description }}</div>

        <div class="flex flex-row-reverse">
          <a
            href="#"
            class="ml-auto items-end bg-indigo-500 text-white text-sm px-2 py-1 mt-3 inline-block rounded hover:bg-indigo-700"
          >Voir la formation</a>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "./../../Layouts/AppLayout";

export default {
  components: {
    AppLayout,
  },

  data() {
    return {
      courseList: this.courses,
    };
  },

  props: ["courses"],

  mounted() {
    console.log(this.courseList);
  },
};
</script>