<script setup lang="ts">
import type { HousingFilters } from '~/types/housing'

definePageMeta({
  layout: 'default',
})

const route = useRoute()
const router = useRouter()

// парсим query из url — чтобы работал прямой переход по ссылке
function parseFiltersFromQuery(q: Record<string, string | string[]>) {
  return {
    city: (q.city as string) || undefined,
    min_price: q.min_price ? Number(q.min_price) : undefined,
    max_price: q.max_price ? Number(q.max_price) : undefined,
    guests: q.guests ? Number(q.guests) : undefined,
    sort: (q.sort as HousingFilters['sort']) || undefined,
    page: q.page ? Math.max(1, Number(q.page)) : 1,
  }
}

const filters = ref<HousingFilters>(parseFiltersFromQuery(route.query))

const cities = [
  { value: 'sochi', label: 'Сочи' },
  { value: 'gelendzhik', label: 'Геленджик' },
  { value: 'anapa', label: 'Анапа' },
  { value: 'adler', label: 'Адлер' },
  { value: 'krasnodar', label: 'Краснодар' },
]

function initFiltersFromRoute() {
  filters.value = parseFiltersFromQuery(route.query)
}

function updateFilters(updates: Partial<HousingFilters>) {
  const next = { ...filters.value, ...updates }
  // при смене фильтра — на первую страницу
  if (updates.page === undefined && updates.city !== undefined) next.page = 1
  filters.value = next
  syncRoute(next)
}

function syncRoute(f: HousingFilters) {
  const query: Record<string, string> = {}
  if (f.city) query.city = f.city
  if (f.min_price) query.min_price = String(f.min_price)
  if (f.max_price) query.max_price = String(f.max_price)
  if (f.guests) query.guests = String(f.guests)
  if (f.sort) query.sort = f.sort
  if (f.page && f.page > 1) query.page = String(f.page)
  router.replace({ query })
}

// если юзер отредактировал url вручную — подхватываем
watch(() => route.query, initFiltersFromRoute, { deep: true })

const { housings, pagination, pending, error } = useHousings(filters)

function goToPage(page: number) {
  updateFilters({ page })
}
</script>

<template>
  <div>
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
      Каталог жилья
    </h1>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
      <aside class="lg:w-64 flex-shrink-0 overflow-visible">
        <div class="lg:sticky lg:top-24 overflow-visible">
          <CatalogFilters
            :filters="filters"
            :cities="cities"
            @update="updateFilters"
          />
        </div>
      </aside>

      <div class="flex-1 min-w-0">
        <div v-if="error" class="p-6 bg-red-50 border border-red-200 rounded-xl">
          <p class="text-red-700 font-medium">Ошибка загрузки данных</p>
          <p class="text-red-600 text-sm mt-1">
            {{ error.message || 'Проверьте, что бэкенд запущен на http://127.0.0.1:8000' }}
          </p>
        </div>

        <div v-else-if="pending" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
          <HousingCardSkeleton v-for="i in 6" :key="i" />
        </div>

        <div v-else-if="housings.length === 0" class="py-12 text-center text-gray-500">
          <p class="text-lg">Ничего не найдено</p>
          <p class="text-sm mt-1">Попробуйте изменить фильтры</p>
        </div>

        <template v-else>
          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
            <HousingCard
              v-for="housing in housings"
              :key="housing.id"
              :housing="housing"
            />
          </div>

          <CatalogPagination
            v-if="pagination"
            :current-page="pagination.current_page"
            :last-page="pagination.last_page"
            :total="pagination.total"
            :from="pagination.from"
            :to="pagination.to"
            @page="goToPage"
          />
        </template>
      </div>
    </div>
  </div>
</template>
