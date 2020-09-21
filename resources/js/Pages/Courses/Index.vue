<template>
    <app-layout>
        <template slot="header">
            Liste des formations
        </template>
        <div
            class="py-6"
            v-for="course in this.courseList"
            v-bind:key="course.id"
        >
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
                    <div class="text-3xl">{{ course.title }}</div>
                    <div class="text-sm text-gray-500">
                        {{ course.episodes_count }} épisodes
                    </div>
                </div>

                <div class="text-sm text-gray-500">
                    {{ course.description }}
                </div>

                <div class="flex flex-row-reverse">
                    <a
                        :href="'/courses/' + course.id"
                        class="ml-auto items-end bg-indigo-500 text-white text-sm px-2 py-1 mt-3 inline-block rounded hover:bg-indigo-700"
                        >Voir la formation</a
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
        AppLayout
    },

    props: ["courses"],

    data() {
        return {
            courseList: this.courses
        };
    },

    mounted() {
        console.log(this.courseList);
    }
};
</script>
