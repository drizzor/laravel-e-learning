<template>
  <app-layout>
    <template slot="header"> Liste des formations </template>
    <!-- Le flash est introduit dans le appServiceProvider : https://inertiajs.com/shared-data -->
    <div
      class="mx-8 mt-5 bg-green-200 text-green-500 p-3 mb-5"
      v-if="$page.flash.success"
    >
      {{ $page.flash.success }}
    </div>
    <div class="py-6" v-for="course in this.courseList" v-bind:key="course.id">
      <div class="mx-8 bg-white rounded shadow p-3">
        <div class="text-sm text-gray-500">
          Mise en ligne par {{ course.owner.name }} -
          <span class="text-gray-500 text-sm">
            {{ course.participants }} participant<span
              v-if="parseInt(course.participants) > 1"
              >s</span
            >
          </span>
        </div>

        <div class="flex justify-between items-center">
          <h1 class="text-3xl">{{ course.title }}</h1>          
          <span class="text-sm text-gray-500">
            {{ course.episodes_count }} épisodes
          </span>
        </div>

        <span class="font-semibold text-sm text-gray-500"><i class="far fa-clock"></i> {{ convert(course.total_duration) }}</span>

        <div class="text-sm text-gray-500 mt-2">
          {{ course.description }}
        </div>

        <div class="flex items-center justify-between">
          <a
            :href="'/courses/' + course.id"
            class="bg-indigo-500 text-white text-sm px-3 py-2 mt-3 inline-block rounded hover:bg-indigo-700"
            >Voir la formation</a
          >

          <a
            :href="'/courses/edit/' + course.id"
            class="bg-gray-500 text-white text-sm px-3 py-2 mt-3 inline-block rounded hover:bg-gray-700"
            v-if="course.update"
            >Editer</a
          >
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

  props: ["courses"],

  data() {
    return {
      courseList: this.courses,
    };
  },

  methods: {
    convert(timestamps) {
      let hours = Math.floor(timestamps / 3600);
      let minutes = Math.floor((timestamps / 60)) - (hours / 60);
      let seconds = timestamps % 60;

      return hours.toString().padStart(2,0) + ':' + minutes.toString().padStart(2,0) + ':' + seconds.toString().padStart(2,0);
    }
  }
};
</script>
