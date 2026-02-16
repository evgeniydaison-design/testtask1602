<script setup lang="ts">
import type { HousingFilters } from '~/types/housing'

const props = defineProps<{
  filters: HousingFilters
  cities: { value: string; label: string }[]
}>()

const emit = defineEmits<{
  update: [filters: Partial<HousingFilters>]
}>()

const cityOptions = computed(() =>
  props.cities.map((c) => ({ value: c.value, label: c.label }))
)

const sortOptions = [
  { value: 'price_asc', label: 'Сначала дешевле' },
  { value: 'price_desc', label: 'Сначала дороже' },
  { value: 'newest', label: 'Сначала новые' },
]

const guestOptions = [
  { value: '2', label: '2 гостя' },
  { value: '3', label: '3 гостя' },
  { value: '4', label: '4 гостя' },
  { value: '5', label: '5 гостей' },
  { value: '6', label: '6+ гостей' },
]

function updateFilter(key: keyof HousingFilters, value: string | number | undefined) {
  emit('update', {
    [key]: value === '' || value === undefined ? undefined : value,
    page: 1,
  })
}

function updatePriceRange(payload: { min_price?: number; max_price?: number }) {
  emit('update', { ...payload, page: 1 })
}

function resetFilters() {
  emit('update', {
    city: undefined,
    min_price: undefined,
    max_price: undefined,
    guests: undefined,
    sort: undefined,
    page: 1,
  })
}

const hasActiveFilters = computed(
  () =>
    !!(
      props.filters.city ||
      props.filters.min_price ||
      props.filters.max_price ||
      props.filters.guests ||
      props.filters.sort
    )
)

// только один фильтр открыт — иначе накладываются
const openFilterId = ref<string | null>(null)

function setOpenFilter(id: string | null) {
  openFilterId.value = id
}
</script>

<template>
  <div class="space-y-1 p-4 bg-white rounded-xl border border-gray-100 shadow-sm overflow-visible">
    <!-- Город -->
    <div class="relative">
      <FilterDropdown
        filter-id="city"
        :open-filter-id="openFilterId"
        :model-value="filters.city"
        :options="cityOptions"
        label="Город"
        placeholder="Все города"
        @update:model-value="(v) => updateFilter('city', v)"
        @open="setOpenFilter('city')"
        @close="setOpenFilter(null)"
      />
    </div>

    <!-- Цена (диапазон) -->
    <div class="relative">
      <FilterPriceRange
        filter-id="price"
        :open-filter-id="openFilterId"
        :min-price="filters.min_price"
        :max-price="filters.max_price"
        @update="updatePriceRange"
        @open="setOpenFilter('price')"
        @close="setOpenFilter(null)"
      />
    </div>

    <!-- Гости -->
    <div class="relative">
      <FilterDropdown
        filter-id="guests"
        :open-filter-id="openFilterId"
        :model-value="filters.guests ? String(filters.guests) : undefined"
        :options="guestOptions"
        label="Гостей"
        placeholder="Любое"
        @update:model-value="(v) => updateFilter('guests', v ? Number(v) : undefined)"
        @open="setOpenFilter('guests')"
        @close="setOpenFilter(null)"
      />
    </div>

    <!-- По цене (сортировка) -->
    <div class="relative">
      <FilterDropdown
        filter-id="sort"
        :open-filter-id="openFilterId"
        :model-value="filters.sort"
        :options="sortOptions"
        label="По цене"
        placeholder="По умолчанию"
        @update:model-value="(v) => updateFilter('sort', v)"
        @open="setOpenFilter('sort')"
        @close="setOpenFilter(null)"
      />
    </div>

    <button
      v-if="hasActiveFilters"
      type="button"
      class="w-full mt-3 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors"
      @click="resetFilters"
    >
      Сбросить фильтры
    </button>
  </div>
</template>
