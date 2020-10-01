<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <!-- Basé sur la doc Inertiajs pour le traitement des formulaires: https://inertiajs.com/forms -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Le flash est introduit dans le appServiceProvider : https://inertiajs.com/shared-data -->
        <div
          class="bg-green-200 text-green-500 p-3 mb-5"
          v-if="$page.flash.success"
        >
          {{ $page.flash.success }}
        </div>

        <div class="w-full">
          <form
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
            @submit.prevent="submit"
          >
            <div class="mb-4">
              <label
                class="block text-gray-700 text-sm font-bold mb-2"
                for="title"
              >
                Titre de la formation
              </label>
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="title"
                type="text"
                v-model="form.title"
              />
              <div v-if="$page.errors.title">{{ $page.errors.title[0] }}</div>
            </div>

            <div class="mb-4">
              <label
                class="block text-gray-700 text-sm font-bold mb-2"
                for="description"
              >
                Description de la formation
              </label>
              <textarea
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="description"
                type="text"
                v-model="form.description"
              ></textarea>
              <div v-if="$page.errors.description">
                {{ $page.errors.description[0] }}
              </div>
            </div>

            <div class="mb-4">
              <h2 class="text-2xl">Episodes de la formation</h2>
              <div v-for="(episode, index) in form.episodes" v-bind:key="index">
                <label
                  class="block text-gray-700 text-sm font-bold mb-2"
                  :for="'title-' + index"
                >
                  Titre de l'épisode n°{{ index + 1 }}
                </label>
                <input
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  :id="'title-' + index"
                  type="text"
                  v-model="form.episodes[index].title"
                />
                <div v-if="$page.errors['episodes.' + index + '.title']">
                  {{ $page.errors["episodes." + index + ".title"][0] }}
                </div>

                <label
                  class="block text-gray-700 text-sm font-bold mb-2"
                  :for="'description-' + index"
                >
                  Description de l'épisode n°{{ index + 1 }}
                </label>
                <textarea
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  :id="'description-' + index"
                  type="text"
                  v-model="form.episodes[index].description"
                ></textarea>
                <div v-if="$page.errors['episodes.' + index + '.description']">
                  {{ $page.errors["episodes." + index + ".description"][0] }}
                </div>

                <label
                  class="block text-gray-700 text-sm font-bold mb-2"
                  :for="'video_url-' + index"
                >
                  URL de la vidéo de l'épisode n°{{ index + 1 }}
                </label>
                <input
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-5"
                  :id="'video_url-' + index"
                  type="text"
                  v-model="form.episodes[index].video_url"
                />
                <div v-if="$page.errors['episodes.' + index + '.video_url']">
                  {{ $page.errors["episodes." + index + ".video_url"][0] }}
                </div>
              </div>
            </div>

            <div class="flex mb-5">
              <button
                class="py-2 px-4 bg-green-600 rounded my-1 text-white block mr-1"
                @click.prevent="add"
                v-if="form.episodes.length < 15"
              >
                <i class="fas fa-plus"></i>
              </button>

              <button
                class="py-2 px-4 bg-red-600 rounded my-1 text-white block"
                @click.prevent="remove"
                v-if="form.episodes.length > 1"
              >
                <i class="fas fa-trash"></i>
              </button>
            </div>

            <button
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              type="submit"
            >
              Créer ma formation
            </button>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";

export default {
  components: {
    AppLayout,
  },

  data() {
    return {
      form: {
        title: null,
        description: null,
        episodes: [{ title: null, description: null, video_url: null }],
      },
    };
  },

  methods: {
    submit() {
      this.$inertia.post("/courses", this.form);
    },
    add() {
      this.form.episodes.push({
        title: null,
        description: null,
        video_url: null,
      });
    },
    remove() {
      this.form.episodes.pop();
    },
  },
};
</script>
