<script setup lang="ts">
import type { Housing } from '~/types/housing'

definePageMeta({
  layout: 'default',
})

const route = useRoute()
const id = computed(() => Number(route.params.id))

const config = useRuntimeConfig()
const apiBase = config.public.apiBase as string

const { data, pending, error } = useFetch<{ data: Housing }>(`${apiBase}/housings/${id.value}`, {
  key: `housing-${id.value}`,
})

const housing = computed(() => data.value?.data ?? null)
</script>

<template>
  <div>
    <NuxtLink
      to="/catalog"
      class="inline-flex items-center gap-2 text-gray-600 hover:text-primary-600 font-medium mb-6 transition-colors"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Назад к каталогу
    </NuxtLink>

    <div v-if="error" class="p-6 bg-red-50 border border-red-200 rounded-xl">
      <p class="text-red-700 font-medium">Ошибка загрузки</p>
      <p class="text-red-600 text-sm mt-1">{{ error.message }}</p>
    </div>

    <div v-else-if="pending" class="animate-pulse">
      <div class="aspect-[16/9] bg-gray-200 rounded-xl mb-6" />
      <div class="h-8 bg-gray-200 rounded w-2/3 mb-4" />
      <div class="h-4 bg-gray-200 rounded w-1/2 mb-6" />
    </div>

    <article v-else-if="housing" class="max-w-4xl">
      <div class="aspect-[16/9] bg-gray-200 rounded-xl overflow-hidden mb-6">
        <img
          :src="housing.image_url"
          :alt="housing.title"
          class="w-full h-full object-cover"
        />
      </div>
      <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
        {{ housing.title }}
      </h1>
      <p class="text-gray-500 mb-4 flex items-center gap-2">
        <span>{{ housing.city }}</span>
        <span v-if="housing.address">· {{ housing.address }}</span>
      </p>
      <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-6">
        <span>{{ housing.guests }} гостей</span>
        <span>{{ housing.bedrooms }} спален</span>
        <span>{{ housing.beds }} кроватей</span>
        <span>{{ housing.baths }} ванн</span>
      </div>
      <div class="text-2xl font-bold text-primary-600 mb-6">
        {{ housing.price.toLocaleString('ru-RU') }} ₽ <span class="text-sm font-normal text-gray-500">/ ночь</span>
      </div>
      <p v-if="housing.description" class="text-gray-700 mb-6">
        {{ housing.description }}
      </p>
      <div v-if="housing.amenities?.length" class="border-t border-gray-100 pt-6">
        <h3 class="font-semibold text-gray-900 mb-3">Удобства</h3>
        <div class="flex flex-wrap gap-2">
          <span
            v-for="a in housing.amenities"
            :key="a"
            class="px-3 py-1.5 bg-gray-100 rounded-lg text-sm text-gray-700"
          >
            {{ a }}
          </span>
        </div>
      </div>
    </article>

    <div v-else class="py-12 text-center text-gray-500">
      <p>Жильё не найдено</p>
    </div>
  </div>
</template>
