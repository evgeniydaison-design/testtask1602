<script setup lang="ts">
import type { Housing } from '~/types/housing'

defineProps<{
  housing: Housing
}>()
</script>

<template>
  <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow border border-gray-100">
    <div class="aspect-[4/3] bg-gray-200 overflow-hidden">
      <img
        :src="housing.image_url"
        :alt="housing.title"
        class="w-full h-full object-cover"
        loading="lazy"
      />
    </div>
    <div class="p-4">
      <div class="flex justify-between items-start gap-2 mb-2">
        <h3 class="font-semibold text-gray-900 line-clamp-2">
          {{ housing.title }}
        </h3>
        <span class="text-primary-600 font-bold whitespace-nowrap">
          {{ housing.price.toLocaleString('ru-RU') }} ₽
        </span>
      </div>
      <p class="text-gray-500 text-sm mb-3 flex items-center gap-1">
        <span>{{ housing.city }}</span>
        <span v-if="housing.address">· {{ housing.address }}</span>
      </p>
      <div class="flex flex-wrap gap-3 text-sm text-gray-600 mb-3">
        <span>{{ housing.guests }} гост.</span>
        <span>{{ housing.bedrooms }} спален</span>
        <span>{{ housing.beds }} кроватей</span>
        <span>{{ housing.baths }} ванн</span>
      </div>
      <NuxtLink
        :to="`/housing/${housing.id}`"
        class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors"
      >
        Подробнее
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </NuxtLink>
    </div>
  </article>
</template>
